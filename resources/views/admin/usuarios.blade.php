@extends('layouts.menu')

@section('title', 'Usuarios')

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
            <h2>Gestión de Usuarios</h2>
            <!-- Botón para abrir modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarUsuario">
                <i class="fa fa-user-plus"></i> Agregar Usuario
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
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>FechaRegistro</th>
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
                            <td>**********</td>
                            <td>{{ $usuario->IdRol }}</td>
                            <td>{{ $usuario->FechaRegistro }}</td>
                            <td>
                                <!-- Botón editar -->
                                <a href="#" class="btn btn-sm btn-warning"
                                    data-id="{{ $usuario->IdUsuario }}"
                                    data-nombre="{{ $usuario->Nombre }}"
                                    data-apellido="{{ $usuario->Apellido }}"
                                    data-username="{{ $usuario->NombreUsuario }}"
                                    data-rol="{{ $usuario->IdRol == 1 ? 'administrador' : 'observador' }}"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                                    onclick="cargarDatosUsuario(this)">
                                    <i class="fa fa-edit"></i>
                                </a>

                               
                                <!-- Botón eliminar -->
                                <form action="{{ route('usuarios.destroy', $usuario->IdUsuario) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
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

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('usuarios.guardar') }}" method="POST">
                @csrf   
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                            
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select id="rol" name="rol" class="form-select">
                                <option value="administrador">Administrador</option>
                                <option value="observador">Observador</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditarUsuario" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" id="edit-nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-apellido" class="form-label">Apellido</label>
                            <input type="text" id="edit-apellido" name="apellido" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-username" class="form-label">Nombre de Usuario</label>
                            <input type="text" id="edit-username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-password" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" id="edit-password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="mb-3">
                            <label for="edit-rol" class="form-label">Rol</label>
                            <select id="edit-rol" name="rol" class="form-select" required>
                                <option value="administrador">Administrador</option>
                                <option value="observador">Observador</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function cargarDatosUsuario(button) {
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const apellido = button.getAttribute('data-apellido');
            const username = button.getAttribute('data-username');
            const rol = button.getAttribute('data-rol');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-apellido').value = apellido;
            document.getElementById('edit-username').value = username;
            document.getElementById('edit-rol').value = rol;

            const form = document.getElementById('formEditarUsuario');
            form.action = `/usuarios/editar/${id}`;
        }
    </script>
@endsection
