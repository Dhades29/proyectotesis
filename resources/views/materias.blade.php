@extends('layouts.menu')

@section('title', 'Materias')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Gestión de Materias</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarMateria">
            <i class="fa fa-plus"></i> Agregar Materia
        </button>
    </div>

    <!-- Tabla de materias -->
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se recorrerán las materias -->
                
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para agregar materia -->
<div class="modal fade" id="modalAgregarMateria" tabindex="-1" aria-labelledby="modalAgregarMateriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarMateriaLabel">Agregar Nueva Materia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Materia</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection