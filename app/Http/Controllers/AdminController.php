<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //mostrar vistas
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function reportes(){
        return view('admin.reportes');
    }

    public function respuestas(){
        return view('admin.respuestas');
    }


}
