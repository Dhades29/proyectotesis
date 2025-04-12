<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//PARA RETORNAR UNA VISTA
Route::get('/usuarios',function () {
    return view('usuarios');
})->name('usuarios');

Route::get('/materias', function () {
    return view('materias');
})->name('materias');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/AsignarFormulario', function () {
    return view('aForms');
})->name('AsignarFormulario');

Route::get('/CrearFormulario', function () {
    return view('cForms');
})->name('CrearFormulario');

Route::get('/respuestas', function () {
    return view('respuestas');
})->name('respuestas');

Route::get('/reportes', function () {
    return view('reportes');
})->name('reportes');