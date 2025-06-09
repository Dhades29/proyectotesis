@extends('layouts.menu')

@section('title', 'asignarForm')

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
            <h2>Asignar Formulario</h2>
            <!-- Botón para abrir modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
                <i class="fa fa-plus"></i> Asignar Formulario
            </button>
        </div>
        
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
                                <!-- Botón asignar -->
                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalAsignarFormulario">
                                    <i class="fa fa-plus"></i>
                                </a>

                               
                                <!-- Botón eliminar -->
                                <form action="" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar asignaciones -->
    <div class="modal fade" id="modalAsignarFormulario" tabindex="-1" aria-labelledby="modalAsignarFormularioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- Se amplía el tamaño del modal --}}
            <form action="{{ route('usuarios.guardar') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAsignarFormularioLabel">Asignar Formularios</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Tabla de formularios disponibles (registros quemados) --}}
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col"><input type="checkbox" id="checkAll"></th>
                                    <th scope="col">Nombre del Formulario</th>
                                    <th scope="col">Fecha de Creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="formularios[]" value="1"></td>
                                    <td>Encuesta de Satisfacción</td>
                                    <td>2024-06-01</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="formularios[]" value="2"></td>
                                    <td>Formulario de Registro</td>
                                    <td>2024-06-03</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="formularios[]" value="3"></td>
                                    <td>Evaluación Docente</td>
                                    <td>2024-06-04</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="formularios[]" value="4"></td>
                                    <td>Solicitud de Servicios</td>
                                    <td>2024-06-05</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="formularios[]" value="5"></td>
                                    <td>Formulario de Contacto</td>
                                    <td>2024-06-06</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
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

    </script>
@endsection
