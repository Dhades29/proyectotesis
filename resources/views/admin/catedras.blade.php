@extends('layouts.menu')

@section('title', 'Cátedras')

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
        <h2>Gestión de Cátedras</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCatedra">
            <i class="fa fa-plus"></i> Agregar Cátedra
        </button>
    </div>

    <!-- Tabla de Cátedras -->
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre de la Cátedra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catedras as $catedra)
                    <tr>
                        <td>{{ $catedra->IdCatedra }}</td>
                        <td>{{ $catedra->NombreCatedra }}</td>
                        <td>
                            <!-- Editar -->
                            <button class="btn btn-sm btn-warning"
                                data-id="{{ $catedra->IdCatedra }}"
                                data-nombre="{{ $catedra->NombreCatedra }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditarCatedra"
                                onclick="cargarDatosCatedra(this)">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- Eliminar -->
                            <form action="{{ route('catedras.destroy', $catedra->IdCatedra) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cátedra?');">
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
<div class="modal fade" id="modalAgregarCatedra" tabindex="-1" aria-labelledby="modalAgregarCatedraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('catedras.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cátedra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="NombreCatedra" class="form-label">Nombre de la Cátedra</label>
                        <input type="text" name="NombreCatedra" id="NombreCatedra" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditarCatedra" tabindex="-1" aria-labelledby="modalEditarCatedraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditarCatedra" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Cátedra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-NombreCatedra" class="form-label">Nombre de la Cátedra</label>
                        <input type="text" id="edit-NombreCatedra" name="NombreCatedra" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function cargarDatosCatedra(button) {
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-NombreCatedra').value = nombre;

        const form = document.getElementById('formEditarCatedra');
        form.action = `/catedras/${id}`;
    }
</script>
@endsection