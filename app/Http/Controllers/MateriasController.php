<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materias;

class MateriasController extends Controller
{
        // Mostrar todas las materias
    public function index()
    {
        $materias = Materias::all();
        return view('admin.materias', compact('materias'));
    }

    // Mostrar formulario para crear una nueva materia
    public function create()
    {
        return view('materias.create');
    }

    // Guardar una nueva materia
    public function store(Request $request)
    {
        $validated = $request->validate([
            'CodigoMateria' => 'required|string|max:255',
            'Nombre'        => 'required|string|max:255',
            'Modalidad'     => 'required|string|max:255',
        ]);

        Materias::create($validated);

        return redirect()->route('materias')->with('success', 'Materia creada correctamente.');
    }

    // Mostrar formulario para editar una materia
    public function edit($id)
    {
        $materia = Materias::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }

    // Actualizar una materia existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'CodigoMateria' => 'required|string|max:255',
            'Nombre'        => 'required|string|max:255',
            'Modalidad'     => 'required|string|max:255',
        ]);

        $materia = Materias::findOrFail($id);
        $materia->update($validated);

        return redirect()->route('materias')->with('success', 'Materia actualizada correctamente.');
    }

    // Eliminar una materia
    public function destroy($id)
    {
        $materia = Materias::findOrFail($id);
        $materia->delete();

        return redirect()->route('materias')->with('success', 'Materia eliminada correctamente.');
    }
}
