<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\FormulariosController;

//Login
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Usuarios
Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('admin.usuarios');
Route::post('usuarios/guardar', [UsuariosController::class, 'guardar'])->name('usuarios.guardar');
Route::put('/usuarios/editar/{id}', [UsuariosController::class, 'editar'])->name('usuarios.editar');
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

//Formularios
Route::get('/formularios', [FormulariosController::class, 'index'])->name('formularios.index');
Route::post('/formularios', [FormulariosController::class, 'store'])->name('formularios.store');
Route::put('/formularios/{id}', [FormulariosController::class, 'update'])->name('formularios.update');
Route::delete('/formularios/{id}', [FormulariosController::class, 'destroy'])->name('formularios.destroy');


Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('materias', [AdminController::class, 'materias'])->name('admin.materias');

Route::get('respuestas', [AdminController::class, 'respuestas'])->name('admin.respuestas');

Route::get('reportes', [AdminController::class, 'reportes'])->name('admin.reportes');

Route::get('observador/inicio', function () {
    return view('observador.inicio');
})->name('observador.inicio');