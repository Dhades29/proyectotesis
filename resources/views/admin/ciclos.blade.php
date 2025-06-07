@extends('layouts.menu')

@section('title', 'Gestión de Ciclos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Ciclos</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoCiclo">
            <i class="fa fa-plus"></i> Nuevo Ciclo
        </button>
    </div>

    <!-- Modal para nuevo ciclo -->
    <div class="modal fade" id="modalNuevoCiclo" tabindex="-1" aria-labelledby="modalNuevoCicloLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="cicloCrear" method="POST" action="{{ route('ciclos.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nuevo Ciclo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="Anio" name="Anio" required>
                        </div>
                        <div class="mb-3">
                            <label for="Periodo" class="form-label">Periodo</label>
                            <input type="text" class="form-control" id="Periodo" name="Periodo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar Ciclo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de ciclos -->
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Año</th>
                    <th>Periodo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ciclos as $ciclo)
                <tr>
                    <td>{{ $ciclo->IdCiclo }}</td>
                    <td>{{ $ciclo->Anio }}</td>
                    <td>{{ $ciclo->Periodo }}</td>
                    <td>
                        <form action="{{ route('ciclos.destroy', $ciclo->IdCiclo) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este ciclo?')">
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
@endsection
