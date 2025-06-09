<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;
use Illuminate\Http\Request;

class AsignarFormController extends Controller
{
    public function index()
    {
        // Asumiendo que el campo IdRol=2 es 'observador'
        $usuarios = Usuarios::where('IdRol', 2)->get();

        return view('admin.asignarForm', compact('usuarios'));
    }
}
