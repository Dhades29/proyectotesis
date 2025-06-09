<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clases;
use App\Models\Docentes;
use App\Models\Ciclos;
use App\Models\Catedras;
use App\Models\Materias;

class ClasesController extends Controller
{
    public function index()
    {
        $clases = Clases::with(['materias', 'docentes', 'ciclos', 'catedras'])->get();
        $materias = Materias::all();
        $docentes = Docentes::all();
        $ciclos = Ciclos::all();
        $catedras = Catedras::all();
        $edit = false; // Cuando estás en la vista principal, no estás editando

        return view('admin.clases', compact('clases', 'materias', 'docentes', 'ciclos', 'catedras', 'edit'));
    }

    public function create()
    {
        $materias = Materias::all();
        $docentes = Docentes::all();
        $ciclos = Ciclos::all();
        $catedras = Catedras::all();
        $edit = false;
        return view('admin.clases.create', compact('materias', 'docentes', 'ciclos', 'catedras', 'edit'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'IdMateria'  => 'required|integer|exists:materia,IdMateria',
            'IdDocente'  => 'required|integer|exists:docentes,IdDocente',
            'IdCiclo'    => 'required|integer|exists:ciclos,IdCiclo',
            'IdCatedra'  => 'required|integer|exists:catedras,IdCatedra',
            'Seccion'    => 'nullable|string|max:10',
            'Aula'       => 'nullable|string|max:50',
            'Edificio'   => 'nullable|string|max:100',
            'DiaSemana'  => 'nullable|string|max:20',
            'HoraInicio' => 'nullable',
            'HoraFin'    => 'nullable',
            'Inscritos'  => 'nullable|integer',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'El valor seleccionado en :attribute no es válido.',
            'after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'date_format' => 'El formato de :attribute debe ser HH:MM (ej. 14:30).',
        ]);

        Clases::create($data);
        return redirect()->route('clases.index')->with('success', 'Clase creada exitosamente.');
    }

    public function edit($id)
    {
        $clase = Clases::findOrFail($id);
        $materias = Materias::all();
        $docentes = Docentes::all();
        $ciclos = Ciclos::all();
        $catedras = Catedras::all();
        $edit = true;
        return view('admin.clases.create', compact('clase', 'materias', 'docentes', 'ciclos', 'catedras', 'edit'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'IdMateria'  => 'required|integer|exists:materia,IdMateria',
            'IdDocente'  => 'required|integer|exists:docentes,IdDocente',
            'IdCiclo'    => 'required|integer|exists:ciclos,IdCiclo',
            'IdCatedra'  => 'required|integer|exists:catedras,IdCatedra',
            'Seccion'    => 'nullable|string|max:10',
            'Aula'       => 'nullable|string|max:50',
            'Edificio'   => 'nullable|string|max:100',
            'DiaSemana'  => 'nullable|string|max:20',
            'HoraInicio' => 'nullable',
            'HoraFin'    => 'nullable',
            'Inscritos'  => 'nullable|integer',
        ]);

        $clase = Clases::findOrFail($id);
        $clase->update($data);

        return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy($id)
    {
        Clases::destroy($id);
        return redirect()->route('clases.index')->with('success', 'Clase eliminada.');
    }
}