<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\FormulariosController;
use App\Http\Controllers\CatedrasController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\CiclosController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\AsignarFormController;
use App\Http\Controllers\RespuestasController;

//Respuestas de los usuarios a los forms
// Mostrar los formularios asignados al observador
Route::get('/observador/inicio', [RespuestasController::class, 'index'])->name('observador.inicio');
Route::get('/observador/formularios/{asignacionId}/responder', [RespuestasController::class, 'mostrarFormulario'])->name('observador.responder');
Route::post('/observador/formularios/{asignacionId}/responder', [RespuestasController::class, 'guardarRespuestas'])->name('observador.guardarRespuestas');



//Asignar formularios a un usuario
Route::get('/asignar-form', [AsignarFormController::class, 'index'])->name('asignarForm.index');
Route::post('/asignaciones/store', [AsignarFormController::class, 'store'])->name('asignaciones.store');


//materias crud
Route::get('/materias', [MateriasController::class, 'index'])->name('materias');
Route::get('/materias/crear', [MateriasController::class, 'create'])->name('materias.create');
Route::post('/materias', [MateriasController::class, 'store'])->name('materias.store');
Route::get('/materias/{id}/editar', [MateriasController::class, 'edit'])->name('materias.edit');
Route::put('/materias/{id}', [MateriasController::class, 'update'])->name('materias.update');
Route::delete('/materias/{id}', [MateriasController::class, 'destroy'])->name('materias.destroy');

//ciclos crud
Route::get('/ciclos', [CiclosController::class, 'index'])->name('ciclos.index');
Route::post('/ciclos', [CiclosController::class, 'store'])->name('ciclos.store');
Route::put('/ciclos/{id}', [CiclosController::class, 'update'])->name('ciclos.update');
Route::delete('/ciclos/{id}', [CiclosController::class, 'destroy'])->name('ciclos.destroy');

// Cátedras CRUD
Route::get('/catedras', [CatedrasController::class, 'index'])->name('catedras.index');
Route::post('/catedras', [CatedrasController::class, 'store'])->name('catedras.store');
Route::get('/catedras/{IdCatedra}/edit', [CatedrasController::class, 'edit'])->name('catedras.edit');
Route::put('/catedras/{IdCatedra}', [CatedrasController::class, 'update'])->name('catedras.update');
Route::delete('/catedras/{IdCatedra}', [CatedrasController::class, 'destroy'])->name('catedras.destroy');

//Clases crud
Route::get('/clases', [ClasesController::class, 'index'])->name('clases.index');
Route::get('/clases/crear', [ClasesController::class, 'create'])->name('clases.create');
Route::post('/clases', [ClasesController::class, 'store'])->name('clases.store');
Route::get('/clases/{id}/editar', [ClasesController::class, 'edit'])->name('clases.edit');
Route::put('/clases/{id}', [ClasesController::class, 'update'])->name('clases.update');
Route::delete('/clases/{id}', [ClasesController::class, 'destroy'])->name('clases.destroy');

//Login
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Usuarios
Route::get('/usuarios', [UsuariosController::class, 'usuarios'])->name('admin.usuarios');
Route::post('usuarios/guardar', [UsuariosController::class, 'guardar'])->name('usuarios.guardar');
Route::put('/usuarios/{id}', [UsuariosController::class, 'editar'])->name('usuarios.editar');
Route::delete('usuarios/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');

//Formularios
Route::get('/formularios', [FormulariosController::class, 'index'])->name('formularios.index');
Route::post('/formularios', [FormulariosController::class, 'store'])->name('formularios.store');
Route::get('/formularios/{id}/detalles', [FormulariosController::class, 'detalles'])->name('formularios.detalles');
Route::delete('/formularios/{id}', [FormulariosController::class, 'destroy'])->name('formularios.destroy');

Route::get('/admin/formularios/{id}/editar-parcial', [App\Http\Controllers\FormulariosController::class, 'editarParcial']);
Route::put('/formularios/{id}', [FormulariosController::class, 'update'])->name('formularios.update');

//Docentes
// Mostrar todos los docentes
Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
 
// Mostrar formulario para crear un nuevo docente
Route::get('/docentes/create', [App\Http\Controllers\DocenteController::class, 'create'])->name('docentes.create');
 
// Guardar un nuevo docente
Route::post('/docentes', [App\Http\Controllers\DocenteController::class, 'store'])->name('docentes.store');
 
// Mostrar un docente específico
Route::get('/docentes/{IdDocente}', [App\Http\Controllers\DocenteController::class, 'show'])->name('docentes.show');
 
// Mostrar formulario para editar un docente
Route::get('/docentes/{IdDocente}/edit', [App\Http\Controllers\DocenteController::class, 'edit'])->name('docentes.edit');
 
// Actualizar un docente
Route::put('/docentes/{IdDocente}', [App\Http\Controllers\DocenteController::class, 'update'])->name('docentes.update');
 
// Eliminar un docente
Route::delete('/docentes/{IdDocente}', [App\Http\Controllers\DocenteController::class, 'destroy'])->name('docentes.destroy');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('respuestas', [AdminController::class, 'respuestas'])->name('admin.respuestas');

Route::get('reportes', [AdminController::class, 'reportes'])->name('admin.reportes');

