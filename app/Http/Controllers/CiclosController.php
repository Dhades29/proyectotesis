<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciclos;

class CiclosController extends Controller
{
    public function index()
    {
        $ciclos = Ciclos::all();
        return view('admin.ciclos', compact('ciclos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Agrega aquí otras validaciones según los campos de Ciclos
        ]);

        Ciclos::create([
            'nombre' => $request->input('nombre'),
            // Agrega aquí otros campos según el modelo
        ]);

        return redirect()->route('ciclos.index')->with('success', 'Ciclo creado correctamente.');
    }

    public function destroy($id)
    {
        $ciclo = Ciclos::findOrFail($id);
        $ciclo->delete();

        return redirect()->route('ciclos.index')->with('success', 'Ciclo eliminado correctamente.');
    }
}
