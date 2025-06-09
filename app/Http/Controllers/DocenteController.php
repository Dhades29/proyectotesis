<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docentes;
class DocenteController extends Controller
{
    // Mostrar todos los docentes
    public function index()
    {
        $docentes = Docentes::all();
        return view('admin.docentes', compact('docentes'));
    }
 
    // Mostrar formulario
    public function create()
    {
        return view('admin.docentes_create');
    }
 
    // Guardar un nuevo docente
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
        ]);
 
        Docentes::create($request->only(['Nombre', 'Apellido']));
        return redirect()->route('docentes.index')->with('success', 'Docente creado correctamente.');
    }
 
    // Mostrar un docente específico
    public function show($id)
    {
        $docente = Docentes::findOrFail($id);
        return view('admin.docentes_show', compact('docente'));
    }
 
    // Mostrar formulario de edición
    public function edit($id)
    {
        $docente = Docentes::findOrFail($id);
        return view('admin.docentes_edit', compact('docente'));
    }
 
    // Actualizar un docente
    public function update(Request $request, $id)
    {
        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
        ]);
 
        $docente = Docentes::findOrFail($id);
        $docente->update($request->only(['Nombre', 'Apellido']));
        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }
 
    // Eliminar un docente
    public function destroy($id)
    {
        $docente = Docentes::findOrFail($id);
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
