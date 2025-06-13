<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Asignaciones;
use App\Models\Respuestas;
use App\Models\Preguntas;
use App\Models\Secciones;

//agregar un filtro para filtrar formularios pendientes y finalizados

class RespuestasController extends Controller
{
    public function index()
    {
        $idUsuario = session('IdUsuario');

        if (!session()->has('IdUsuario')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        $asignaciones = Asignaciones::with('formulario')
            ->where('IdUsuario', $idUsuario)
            ->get();

        return view('observador.inicio', compact('asignaciones'));
    }

    public function mostrarFormulario($asignacionId)
    {
        // Obtener la asignación y el formulario relacionado
        $asignacion = Asignaciones::with('formulario')->findOrFail($asignacionId);
        $formulario = $asignacion->formulario;

        // Obtener las secciones del formulario, con sus preguntas y las opciones de cada pregunta
        $secciones = Secciones::where('IdFormulario', $formulario->IdFormulario)
            ->with(['preguntas' => function($q) {
                $q->with('opciones');
            }])
            ->orderBy('Orden')
            ->get();

        return view('observador.responder', compact('asignacion', 'formulario', 'secciones'));
    }

    public function guardarRespuestas(Request $request, $asignacionId)
    {
        $respuestas = $request->input('respuestas');

        if (!$respuestas || !is_array($respuestas)) {
            return redirect()->back()->with('error', 'No se enviaron respuestas válidas.');
        }

        $preguntasObligatorias = Preguntas::where('EsObligatoria', true)->pluck('IdPregunta')->toArray();
        $errores = [];

        // Validar que las preguntas obligatorias hayan sido respondidas
        $tipoTextoErrorMostrado = false;
        $tipoSeleccionErrorMostrado = false;
        $tipoMultipleErrorMostrado = false;

        foreach ($preguntasObligatorias as $preguntaId) {
            if (!isset($respuestas[$preguntaId])) {
                $errores[] = "Debe responder todas las preguntas obligatorias.";
                continue;
            }

            $pregunta = Preguntas::find($preguntaId);
            $tipo = strtolower($pregunta->TipoRespuesta);

            // Validar preguntas de texto
            if ($tipo == 'texto' && empty($respuestas[$preguntaId]['texto'])) {
                if (!$tipoTextoErrorMostrado) {
                    $errores[] = "Debe responder todas las preguntas de texto.";
                    $tipoTextoErrorMostrado = true;
                }
            }

            // Validar preguntas de opción única y booleano
            if (($tipo == 'seleccion' || $tipo == 'booleano') && empty($respuestas[$preguntaId]['opcion']) && $respuestas[$preguntaId]['opcion'] !== '0') {
                if (!$tipoSeleccionErrorMostrado) {
                    $errores[] = "Debe seleccionar una opción en todas las preguntas de selección única o de tipo Sí/No.";
                    $tipoSeleccionErrorMostrado = true;
                }
            }

            // Validar preguntas de opción múltiple
            if ($tipo == 'multiple' && empty($respuestas[$preguntaId])) {
                if (!$tipoMultipleErrorMostrado) {
                    $errores[] = "Debe seleccionar al menos una opción en todas las preguntas de selección múltiple.";
                    $tipoMultipleErrorMostrado = true;
                }
            }
        }

        if (count($errores) > 0) {
            return redirect()->back()->withInput()->withErrors($errores);
        }

        // Guardar respuestas
        foreach ($respuestas as $preguntaId => $respuesta) {
            $pregunta = \App\Models\Preguntas::find($preguntaId);

            if (!$pregunta) {
                continue; // Saltar si la pregunta no existe
            }

            $tipo = strtolower($pregunta->TipoRespuesta);

            if ($tipo == 'multiple' && is_array($respuesta)) {
                foreach ($respuesta as $opcionId) {
                    \App\Models\Respuestas::create([
                        'IdAsignacion' => $asignacionId,
                        'IdPregunta' => $preguntaId,
                        'IdOpcion' => $opcionId,
                        'FechaRespuesta' => now(),
                    ]);
                }
            } else {
                \App\Models\Respuestas::create([
                    'IdAsignacion' => $asignacionId,
                    'IdPregunta' => $preguntaId,
                    'RespuestaTexto' => ($tipo == 'texto') ? ($respuesta['texto'] ?? null) : 
                                    (($tipo == 'booleano') ? ($respuesta['opcion'] == 1 ? 'Sí' : 'No') : null),
                    'IdOpcion' => ($tipo == 'seleccion') ? ($respuesta['opcion'] ?? null) : null,
                    'FechaRespuesta' => now(),
                ]);
            }
        }

        return redirect()->route('observador.inicio')->with('success', 'Respuestas guardadas correctamente.');
    }
}
