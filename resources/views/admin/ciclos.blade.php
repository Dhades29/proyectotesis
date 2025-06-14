@extends('layouts.menu')

@section('title', 'Ciclos')

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
            <h2>Gestión de Ciclos</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCiclo">
                <i class="fa fa-plus"></i> Agregar Ciclo
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Año</th>
                        <th>Periodo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ciclos as $ciclo)
                        <tr>
                            <td>{{ $ciclo->IdCiclo }}</td>
                            <td>{{ $ciclo->Anio }}</td>
                            <td>{{ $ciclo->Periodo }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning"
                                    data-id="{{ $ciclo->IdCiclo }}"
                                    data-anio="{{ $ciclo->Anio }}"
                                    data-periodo="{{ $ciclo->Periodo }}"
                                    data-bs-toggle="modal" data-bs-target="#modalEditarCiclo"
                                    onclick="cargarDatosCiclo(this)">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form action="{{ route('ciclos.destroy', $ciclo->IdCiclo) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Deseas eliminar este ciclo?');">
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

    <!-- Modal Agregar -->
    <div class="modal fade" id="modalAgregarCiclo" tabindex="-1" aria-labelledby="modalAgregarCicloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('ciclos.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Ciclo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" id="anio" name="Anio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="periodo" class="form-label">Periodo</label>
                            <input type="text" id="periodo" name="Periodo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Ciclo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditarCiclo" tabindex="-1" aria-labelledby="modalEditarCicloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditarCiclo" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Ciclo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="IdCiclo">
                        <div class="mb-3">
                            <label for="edit-anio" class="form-label">Año</label>
                            <input type="number" id="edit-anio" name="Anio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-periodo" class="form-label">Periodo</label>
                            <input type="text" id="edit-periodo" name="Periodo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Ciclo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        function cargarDatosCiclo(button) {
            const id = button.getAttribute('data-id');
            const anio = button.getAttribute('data-anio');
            const periodo = button.getAttribute('data-periodo');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-anio').value = anio;
            document.getElementById('edit-periodo').value = periodo;

            const form = document.getElementById('formEditarCiclo');
            form.action = `/ciclos/${id}`;
        }
    </script>
@endsection