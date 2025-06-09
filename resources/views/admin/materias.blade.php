@extends('layouts.menu')

@section('title', 'Materias')

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
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Modalidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                        <tr>
                            <td>{{ $materia->IdMateria }}</td>
                            <td>{{ $materia->CodigoMateria }}</td>
                            <td>{{ $materia->Nombre }}</td>
                            <td>{{ $materia->Modalidad }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"
                                    data-id="{{ $materia->IdMateria }}"
                                    data-codigo="{{ $materia->CodigoMateria }}"
                                    data-nombre="{{ $materia->Nombre }}"
                                    data-modalidad="{{ $materia->Modalidad }}"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarMateria"
                                    onclick="cargarDatosMateria(this)">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('materias.destroy', $materia->IdMateria) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Deseas eliminar esta materia?');">
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

    <!-- Modal para agregar materia -->
    <div class="modal fade" id="modalAgregarMateria" tabindex="-1" aria-labelledby="modalAgregarMateriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('materias.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nueva Materia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" id="codigo" name="CodigoMateria" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="Nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <select id="modalidad" name="Modalidad" class="form-select" required>
                                <option value="">Seleccione una opción</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Semipresencial">Semipresencial</option>
                                <option value="Virtual">Virtual</option>
                            </select>
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

    <!-- Modal para editar materia -->
    <div class="modal fade" id="modalEditarMateria" tabindex="-1" aria-labelledby="modalEditarMateriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditarMateria" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Materia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="mb-3">
                            <label for="edit-codigo" class="form-label">Código</label>
                            <input type="text" id="edit-codigo" name="CodigoMateria" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" id="edit-nombre" name="Nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-modalidad" class="form-label">Modalidad</label>
                            <select id="edit-modalidad" name="Modalidad" class="form-select" required>
                                <option value="Presencial">Presencial</option>
                                <option value="Semipresencial">Semipresencial</option>
                                <option value="Virtual">Virtual</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Materia</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para cargar datos en modal de edición -->
    <script>
        function cargarDatosMateria(button) {
            const id = button.getAttribute('data-id');
            const codigo = button.getAttribute('data-codigo');
            const nombre = button.getAttribute('data-nombre');
            const modalidad = button.getAttribute('data-modalidad');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-codigo').value = codigo;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-modalidad').value = modalidad;

            const form = document.getElementById('formEditarMateria');
            form.action = `/materias/${id}`;
        }
    </script>
@endsection