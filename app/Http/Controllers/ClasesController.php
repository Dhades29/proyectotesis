<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clases;

class ClasesController extends Controller
{
    public function index()
    {
        $clases = Clases::all();
        return view('admin.clases', compact('clases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Agrega aquí otras validaciones según los campos de Clases
        ]);

        Clases::create([
            'nombre' => $request->input('nombre'),
            // Agrega aquí otros campos según el modelo
        ]);

        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function destroy($id)
    {
        $clase = Clases::findOrFail($id);
        $clase->delete();

        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    }
}
