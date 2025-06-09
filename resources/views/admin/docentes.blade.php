@extends('layouts.menu')

@section('title', 'Docentes')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gestión de Docentes</h2>
            <!-- Botón para abrir modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarDocente">
                <i class="fa fa-user-plus"></i> Agregar Docente
            </button>
        </div>

        <!-- Tabla de docentes -->
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($docentes as $docente)
                        <tr>
                            <td>{{ $docente->IdDocente }}</td>
                            <td>{{ $docente->Nombre }}</td>
                            <td>{{ $docente->Apellido }}</td>
                            <td>
                                <!-- Botón editar -->
                                <a href="#" class="btn btn-sm btn-warning"
                                    data-id="{{ $docente->IdDocente }}"
                                    data-nombre="{{ $docente->Nombre }}"
                                    data-apellido="{{ $docente->Apellido }}"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarDocente"
                                    onclick="cargarDatosDocente(this)">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <!-- Botón eliminar -->
                                <form action="{{ route('docentes.destroy', $docente->IdDocente) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Deseas eliminar este docente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar docente -->
    <div class="modal fade" id="modalAgregarDocente" tabindex="-1" aria-labelledby="modalAgregarDocenteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Docente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="Nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="Apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Docente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar docente -->
    <div class="modal fade" id="modalEditarDocente" tabindex="-1" aria-labelledby="modalEditarDocenteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditarDocente" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Docente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">

                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" id="edit-nombre" name="Nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-apellido" class="form-label">Apellido</label>
                            <input type="text" id="edit-apellido" name="Apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Docente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para cargar datos en modal -->
    <script>
        function cargarDatosDocente(button) {
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-apellido').value = apellido;

            const form = document.getElementById('formEditarDocente');
            form.action = `/docentes/${id}`;
        }
    </script>
@endsection