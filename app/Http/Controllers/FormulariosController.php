<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Formularios;
use App\Models\Secciones;
use App\Models\Preguntas;
use App\Models\Opciones;

class FormulariosController extends Controller
{
    public function index()
    {
        $formularios = Formularios::all();
        return view('admin.aForms', compact('formularios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'secciones' => 'required|array|min:1',
            'secciones.*.titulo' => 'required|string|max:255',
            'secciones.*.preguntas' => 'required|array|min:1',
            'secciones.*.preguntas.*.texto' => 'required|string|max:1000',
            'secciones.*.preguntas.*.tipo' => 'required|string|in:texto,seleccion,multiple,booleano',
            // Opciones se validan en el ciclo
        ]);

        DB::beginTransaction();
        try {
            // 1. Crear el formulario
            $formulario = Formularios::create([
                'NombreFormulario' => $request->input('nombre'),
                'Descripcion' => '', // Puedes agregar campo de descripción si lo deseas
                'FechaCreacion' => Carbon::now(),
            ]);

            // 2. Recorrer secciones
            $ordenSeccion = 1;
            foreach ($request->input('secciones') as $seccionData) {
                $seccion = Secciones::create([
                    'IdFormulario' => $formulario->IdFormulario,
                    'Titulo' => $seccionData['titulo'],
                    'Orden' => $ordenSeccion++,
                ]);

                // 3. Recorrer preguntas de la sección
                $ordenPregunta = 1;
                foreach ($seccionData['preguntas'] as $preguntaData) {
                    $esObligatoria = isset($preguntaData['es_obligatoria']) && $preguntaData['es_obligatoria'] == '1' ? 1 : 0;

                    $pregunta = Preguntas::create([
                        'IdSeccion' => $seccion->IdSeccion,
                        'Texto' => $preguntaData['texto'],
                        'TipoRespuesta' => $preguntaData['tipo'],
                        'Orden' => $ordenPregunta++,
                        'EsObligatoria' => $esObligatoria,
                    ]);

                    // 4. Si la pregunta tiene opciones (selección única o múltiple)
                    if (
                        in_array($preguntaData['tipo'], ['seleccion', 'multiple']) &&
                        isset($preguntaData['opciones']) &&
                        is_array($preguntaData['opciones'])
                    ) {
                        $ordenOpcion = 1;
                        foreach ($preguntaData['opciones'] as $opcionTexto) {
                            Opciones::create([
                                'IdPregunta' => $pregunta->IdPregunta,
                                'Texto' => $opcionTexto,
                                'Orden' => $ordenOpcion++,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.usuarios')->with('success', 'Formulario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al guardar el formulario: ' . $e->getMessage());
        }
    }

    public function detalles($id)
    {
        $formulario = \App\Models\Formularios::findOrFail($id);

        // Cargar secciones, preguntas y opciones
        $secciones = \App\Models\Secciones::where('IdFormulario', $id)
            ->orderBy('Orden')
            ->get()
            ->map(function($seccion) {
                $seccion->preguntas = \App\Models\Preguntas::where('IdSeccion', $seccion->IdSeccion)
                    ->orderBy('Orden')
                    ->get()
                    ->map(function($pregunta) {
                        $pregunta->opciones = \App\Models\Opciones::where('IdPregunta', $pregunta->IdPregunta)
                            ->orderBy('Orden')
                            ->get();
                        return $pregunta;
                    });
                return $seccion;
            });

        return view('admin.partials.detalles_formulario', compact('formulario', 'secciones'));
    }
    
    public function actualizarPregunta(Request $request, $idFormulario, $idPregunta)
    {
        $request->validate([
            'texto' => 'required|string|max:1000',
            'tipo' => 'required|string|in:texto,seleccion,multiple,booleano',
            'es_obligatoria' => 'nullable|boolean',
            'opciones' => 'array',
            'opciones.*' => 'string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $pregunta = \App\Models\Preguntas::findOrFail($idPregunta);

            $pregunta->Texto = $request->input('texto');
            $pregunta->TipoRespuesta = $request->input('tipo');
            $pregunta->EsObligatoria = $request->input('es_obligatoria', 0);
            $pregunta->save();

            // Solo sincroniza opciones si el tipo es seleccion o multiple
            if (in_array($pregunta->TipoRespuesta, ['seleccion', 'multiple'])) {
                $nuevasOpciones = $request->input('opciones', []);

                // Elimina opciones que ya no están
                \App\Models\Opciones::where('IdPregunta', $pregunta->IdPregunta)
                    ->whereNotIn('Texto', $nuevasOpciones)
                    ->delete();

                // Actualiza o crea opciones
                $orden = 1;
                foreach ($nuevasOpciones as $textoOpcion) {
                    $opcion = \App\Models\Opciones::firstOrNew([
                        'IdPregunta' => $pregunta->IdPregunta,
                        'Texto' => $textoOpcion,
                    ]);
                    $opcion->Orden = $orden++;
                    $opcion->save();
                }
            } else {
                // Si el tipo ya no es seleccion/multiple, elimina todas las opciones
                \App\Models\Opciones::where('IdPregunta', $pregunta->IdPregunta)->delete();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta actualizada correctamente.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar un formulario
    public function destroy($id)
    {
        $formulario = Formularios::findOrFail($id);
        $formulario->delete();

        return redirect()->route('formularios.index')->with('success', 'Formulario eliminado correctamente.');
    }


    // Mostrar la vista de edición
    public function editarParcial($id)
    {
        // 1. Obtener el formulario
        $formulario = Formularios::findOrFail($id);

        // 2. Obtener las secciones del formulario
        $secciones = Secciones::where('IdFormulario', $formulario->IdFormulario)
            ->orderBy('Orden')
            ->get();

        // 3. Para cada sección, obtener sus preguntas y para cada pregunta, sus opciones
        foreach ($secciones as $seccion) {
            $preguntas = Preguntas::where('IdSeccion', $seccion->IdSeccion)
                ->orderBy('Orden')
                ->get();

            foreach ($preguntas as $pregunta) {
                $opciones = Opciones::where('IdPregunta', $pregunta->IdPregunta)
                    ->orderBy('Orden')
                    ->get();
                $pregunta->opciones = $opciones;
            }
            $seccion->preguntas = $preguntas;
        }

        // 4. Pasar $formulario y $secciones a la vista parcial
        return view('admin.partials.formulario_edicion', compact('formulario', 'secciones'));
    }

     // Guardar cambios de edición
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $formulario = Formularios::findOrFail($id);
            $formulario->NombreFormulario = $request->input('nombre');
            $formulario->save();

            // Eliminar secciones, preguntas y opciones existentes
            $secciones = Secciones::where('IdFormulario', $id)->get();
            foreach ($secciones as $seccion) {
                $preguntas = DB::table('preguntas')->where('IdSeccion', $seccion->IdSeccion)->get();
                foreach ($preguntas as $pregunta) {
                    DB::table('opciones')->where('IdPregunta', $pregunta->IdPregunta)->delete();
                }
                DB::table('preguntas')->where('IdSeccion', $seccion->IdSeccion)->delete();
            }
            Secciones::where('IdFormulario', $id)->delete();

            // Crear nuevas secciones, preguntas y opciones
            $ordenSeccion = 1;
            foreach ($request->input('secciones', []) as $seccionData) {
                $seccion = Secciones::create([
                    'IdFormulario' => $id,
                    'Titulo' => $seccionData['titulo'] ?? '',
                    'Orden' => $ordenSeccion++,
                ]);
                if (!empty($seccionData['preguntas'])) {
                    foreach ($seccionData['preguntas'] as $preguntaData) {
                        $preguntaId = DB::table('preguntas')->insertGetId([
                            'IdSeccion' => $seccion->IdSeccion,
                            'Texto' => $preguntaData['texto'] ?? '',
                            'TipoRespuesta' => $preguntaData['tipo'] ?? 'texto',
                            'EsObligatoria' => isset($preguntaData['es_obligatoria']) ? 1 : 0,
                        ]);
                        if (in_array($preguntaData['tipo'] ?? '', ['seleccion', 'multiple'])) {
                            if (!empty($preguntaData['opciones'])) {
                                foreach ($preguntaData['opciones'] as $opcionTexto) {
                                    DB::table('opciones')->insert([
                                        'IdPregunta' => $preguntaId,
                                        'Texto' => $opcionTexto,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        });

        return redirect()->route('formularios.edit', $id)->with('success', 'Formulario actualizado correctamente');
    }


}
