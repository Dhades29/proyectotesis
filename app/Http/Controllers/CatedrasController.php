<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catedras;

class CatedrasController extends Controller
{
    // Mostrar todas las cátedras
    public function index()
    {
        $catedras = Catedras::all();
        return view('admin.catedras', compact('catedras'));
    }

    // Guardar una nueva cátedra
    public function store(Request $request)
    {
        $request->validate([
            'NombreCatedra' => 'required|string|max:255',
        ]);
        Catedras::create([
            'NombreCatedra' => $request->NombreCatedra,
        ]);
        return redirect()->route('catedras.index')->with('success', 'Cátedra creada correctamente.');
    }

    // Mostrar formulario para editar una cátedra
    public function edit($IdCatedra)
    {
        $catedra = Catedras::findOrFail($IdCatedra);
        $catedras = Catedras::all(); // Para mostrar la lista junto al formulario
        return view('admin.catedras', compact('catedras', 'catedra'));
    }

    // Actualizar una cátedra
    public function update(Request $request, $IdCatedra)
    {
        $request->validate([
            'NombreCatedra' => 'required|string|max:255',
        ]);
        $catedra = Catedras::findOrFail($IdCatedra);
        $catedra->update([
            'NombreCatedra' => $request->NombreCatedra,
        ]);
        return redirect()->route('catedras.index')->with('success', 'Cátedra actualizada correctamente.');
    }

    // Eliminar una cátedra
    public function destroy($IdCatedra)
    {
        $catedra = Catedras::findOrFail($IdCatedra);
        $catedra->delete();
        return redirect()->route('catedras.index')->with('success', 'Cátedra eliminada correctamente.');
    }
}
