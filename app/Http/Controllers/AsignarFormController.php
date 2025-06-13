<?php

namespace App\Http\Controllers;    
use Illuminate\Http\Request;
use App\Models\Asignaciones;
use App\Models\Usuarios;
use App\Models\Formularios;
use App\Models\Clases;

class AsignarFormController extends Controller
{
    public function index()
    {
        // Asumiendo que el campo IdRol=2 es 'observador'
        $usuarios = Usuarios::where('IdRol', 2)->get();
        $formularios = Formularios::all();
        $clases = Clases::with('materias')->get();

        return view('admin.asignarForm', compact('usuarios', 'formularios', 'clases'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'IdUsuario' => 'required|exists:usuarios,IdUsuario',
            'IdFormulario' => 'required|array',
            'IdClase' => 'required|exists:clases,IdClase',
            'FechaAsignacion' => 'required|date',
        ]);

        foreach ($request->IdFormulario as $formularioId) {
            Asignaciones::create([
                'IdUsuario' => $request->IdUsuario,
                'IdFormulario' => $formularioId,
                'IdClase' => $request->IdClase,
                'FechaAsignacion' => $request->FechaAsignacion,
                'FechaCompletado' => null, // o lo que necesites
            ]);
        }

        return redirect()->back()->with('success', 'Formulario(s) asignado(s) correctamente.');
    }
}
