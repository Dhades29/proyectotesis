<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuariosController;

//Login
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Usuarios
Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('admin.usuarios');
Route::post('usuarios/guardar', [UsuariosController::class, 'guardar'])->name('usuarios.guardar');
Route::put('/usuarios/editar/{id}', [UsuariosController::class, 'editar'])->name('usuarios.editar');
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('materias', [AdminController::class, 'materias'])->name('admin.materias');

Route::get('AsignarFormulario', [AdminController::class, 'aForms'])->name('admin.AsignarFormulario');

Route::get('CrearFormulario', [AdminController::class, 'cForms'])->name('admin.CrearFormulario');

Route::get('respuestas', [AdminController::class, 'respuestas'])->name('admin.respuestas');

Route::get('reportes', [AdminController::class, 'reportes'])->name('admin.reportes');

Route::get('observador/inicio', function () {
    return view('observador.inicio');
})->name('observador.inicio');
