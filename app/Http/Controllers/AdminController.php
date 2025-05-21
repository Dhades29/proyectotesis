<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //mostrar vistas
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function materias(){
        return view('admin.materias');
    }

    public function aForms(){
        //mostrar vista de asignacion de formularios
        return view('admin.aForms');
    }

    public function cForms(){
        //vista de creacion de formularios
        return view('admin.cForms');
    }

    public function reportes(){
        return view('admin.reportes');
    }

    public function respuestas(){
        return view('admin.respuestas');
    }


}
