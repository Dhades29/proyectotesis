<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciclos;

class CiclosController extends Controller
{
    // Mostrar todos los ciclos en la vista principal
    public function index()
    {
        $ciclos = Ciclos::all();
        return view('admin.ciclos', compact('ciclos'));
    }

    // Guardar un nuevo ciclo
    public function store(Request $request)
    {
        $request->validate([
            'Anio' => 'required|integer',
            'Periodo' => 'required|string|max:255',
        ]);

        Ciclos::create([
            'Anio' => $request->Anio,
            'Periodo' => $request->Periodo,
        ]);

        return redirect()->route('ciclos.index')->with('success', 'Ciclo creado correctamente.');
    }

    // Actualizar un ciclo existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'Anio' => 'required|integer',
            'Periodo' => 'required|string|max:255',
        ]);

        $ciclo = Ciclos::findOrFail($id);
        $ciclo->update([
            'Anio' => $request->Anio,
            'Periodo' => $request->Periodo,
        ]);

        return redirect()->route('ciclos.index')->with('success', 'Ciclo actualizado correctamente.');
    }

    // Eliminar un ciclo
    public function destroy($id)
    {
        $ciclo = Ciclos::findOrFail($id);
        $ciclo->delete();

        return redirect()->route('ciclos.index')->with('success', 'Ciclo eliminado correctamente.');
    }
}
