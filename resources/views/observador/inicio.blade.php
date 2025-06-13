@extends('layouts.menuobservador')

@section('title', 'Formularios Asignados - Observaciones de Clases')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Formularios Asignados - Observaciones de Clases</h2>
    </div>

    <!-- Tabla con datos dinámicos -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            Mis Formularios
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre del Formulario</th>
                        <th>Fecha de Asignación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaciones as $index => $asignacion)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $asignacion->formulario->NombreFormulario }}</td>
                            <td>{{ \Carbon\Carbon::parse($asignacion->FechaAsignacion)->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('observador.responder', ['asignacionId' => $asignacion->IdAsignacion]) }}" class="btn btn-success">
                                    <i class="fa fa-pencil-alt"></i> Responder
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No tienes formularios asignados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
