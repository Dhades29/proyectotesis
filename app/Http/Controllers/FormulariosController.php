<?php

namespace App\Http\Controllers;

use App\Models\Formularios;
use Illuminate\Http\Request;
class FormulariosController extends Controller
{
    public function index()
    {
        $formularios = Formularios::all();
        return view('admin.aForms', compact('formularios'));
    }

    // Guardar un nuevo formulario
    public function store(Request $request)
    {
        $request->validate([
            'nombreFormulario' => 'required|string|max:100',
            // Si agregas más campos, agrégalos aquí
        ]);

        // Mapear el nombre del input al campo del modelo
        Formularios::create([
            'NombreFormulario' => $request->input('nombreFormulario'),
            // Si agregas más campos, agrégalos aquí
        ]);

        return redirect()->route('formularios.index')->with('success', 'Formulario creado correctamente.');
    }

    // Actualizar un formulario existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombreFormulario' => 'required|string|max:100',
            // Si agregas más campos, agrégalos aquí
        ]);

        $formulario = Formularios::findOrFail($id);
        $formulario->NombreFormulario = $request->input('nombreFormulario');
        // Si agregas más campos, agrégalos aquí
        $formulario->save();

        return redirect()->route('formularios.index')->with('success', 'Formulario actualizado correctamente.');
    }

    // Eliminar un formulario
    public function destroy($id)
    {
        $formulario = Formularios::findOrFail($id);
        $formulario->delete();

        return redirect()->route('formularios.index')->with('success', 'Formulario eliminado correctamente.');
    }
}
