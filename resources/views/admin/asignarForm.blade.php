@extends('layouts.menu')

@section('title', 'Asignar Formulario')

@section('content')
<div class="container">
    <h2 class="mb-4">Asignar Formularios a Usuarios</h2>

    <!-- Tabla de usuarios -->
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>NombreUsuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->IdUsuario }}</td>
                        <td>{{ $usuario->Nombre }}</td>
                        <td>{{ $usuario->Apellido }}</td>
                        <td>{{ $usuario->NombreUsuario }}</td>
                        <td>Observador</td>
                        <td>
                            <!-- Botón para abrir modal dinámico -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalAsignarFormulario{{ $usuario->IdUsuario }}">
                                <i class="fa fa-plus"></i> Asignar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal para asignar formularios a este usuario -->
                    <div class="modal fade" id="modalAsignarFormulario{{ $usuario->IdUsuario }}" tabindex="-1" aria-labelledby="modalLabel{{ $usuario->IdUsuario }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('asignaciones.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="IdUsuario" value="{{ $usuario->IdUsuario }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $usuario->IdUsuario }}">Asignar Formularios a {{ $usuario->Nombre }} {{ $usuario->Apellido }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="IdFormulario" class="form-label">Seleccionar Formulario(s)</label>
                                            <select name="IdFormulario[]" class="form-select" multiple required>
                                                @foreach ($formularios as $formulario)
                                                    <option value="{{ $formulario->IdFormulario }}">{{ $formulario->NombreFormulario }}</option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Puedes seleccionar uno o varios formularios.</small>
                                        </div>

                                       <div class="mb-3">
                                            <label for="IdClase" class="form-label">Seleccionar Clase</label>
                                            <select name="IdClase" class="form-select" required>
                                                <option value="">Seleccione una clase</option>
                                                @foreach ($clases as $clase)
                                                    <option value="{{ $clase->IdClase }}">
                                                        {{ $clase->materias->Nombre }} - {{ $clase->DiaSemana }} {{ $clase->HoraInicio }} - Aula: {{ $clase->Aula }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="FechaAsignacion" class="form-label">Fecha de Asignación</label>
                                            <input type="date" name="FechaAsignacion" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <script>
        function cargarDatosUsuario(button) {
            // Obtener los atributos del botón
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');
            const username = button.getAttribute('data-username');
            const rol = button.getAttribute('data-rol');

            // Asignar los valores al formulario del modal
            document.getElementById('edit-id').value = id; // opcional, solo para mostrar o mantener en el frontend
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-apellido').value = apellido;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-rol').value = rol;

        }

        //seleccionar forms
        document.addEventListener("DOMContentLoaded", function () {
            const checkAll = document.getElementById("checkAll");
            const checkboxes = document.querySelectorAll('input[name="formularios[]"]');

            checkAll.addEventListener("change", function () {
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
            });
        });

    </script>
@endsection
