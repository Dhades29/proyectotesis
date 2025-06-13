@extends('layouts.menu')

@section('title', 'Clases')

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
        <h2>Gestión de Clases</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarClase">
            <i class="fa fa-plus"></i> Agregar Clase
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Ciclo</th>
                    <th>Cátedra</th>
                    <th>Sección</th>
                    <th>Aula</th>
                    <th>Edificio</th>
                    <th>Día</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Inscritos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clases as $clase)
                    <tr>
                        <td>{{ $clase->IdClase }}</td>
                        <td>{{ $clase->materias->Nombre ?? 'Sin asignar' }}</td>
                        <td>{{ $clase->docentes->Nombre ?? 'Sin asignar' }}</td>
                        <td>{{ $clase->ciclos->Anio ?? '' }} - {{ $clase->ciclos->Periodo ?? '' }}</td>
                        <td>{{ $clase->catedras->NombreCatedra ?? 'Sin asignar' }}</td>
                        <td>{{ $clase->Seccion }}</td>
                        <td>{{ $clase->Aula }}</td>
                        <td>{{ $clase->Edificio }}</td>
                        <td>{{ $clase->DiaSemana }}</td>
                        <td>{{ $clase->HoraInicio }}</td>
                        <td>{{ $clase->HoraFin }}</td>
                        <td>{{ $clase->Inscritos }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-id="{{ $clase->IdClase }}" data-bs-toggle="modal" data-bs-target="#modalEditarClase" onclick="cargarDatosClase({{ json_encode($clase) }})">
                                <i class="fa fa-edit"></i>
                            </a>

                            <form action="{{ route('clases.destroy', $clase->IdClase) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Deseas eliminar esta clase?');">
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

<!-- Modal Agregar Clase -->
<div class="modal fade" id="modalAgregarClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('clases.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nueva Clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    @include('admin.partials.form-clase')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Clase</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Clase -->
<div class="modal fade" id="modalEditarClase" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditarClase" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Clase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    @include('admin.partials.form-clase', ['modo' => 'edit'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Clase</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formClase');

        if (form) {
            form.addEventListener('submit', function (e) {
                let valid = true;
                let mensajes = [];

                const campos = [
                    { id: 'IdMateria', nombre: 'Materia' },
                    { id: 'IdDocente', nombre: 'Docente' },
                    { id: 'IdCiclo', nombre: 'Ciclo' },
                    { id: 'IdCatedra', nombre: 'Catedra' },
                    { id: 'Seccion', nombre: 'Sección' },
                    { id: 'Aula', nombre: 'Aula' },
                    { id: 'Edificio', nombre: 'Edificio' },
                    { id: 'DiaSemana', nombre: 'Día de la semana' },
                    { id: 'HoraInicio', nombre: 'Hora de inicio' },
                    { id: 'HoraFin', nombre: 'Hora de fin' },
                    { id: 'Inscritos', nombre: 'Inscritos' },
                ];

                campos.forEach(campo => {
                    const input = document.getElementById(campo.id);
                    if (!input || input.value.trim() === '') {
                        valid = false;
                        mensajes.push(`El campo "${campo.nombre}" es obligatorio.`);
                        input?.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert(mensajes.join('\n'));
                }
            });
        }
    });

    function cargarDatosClase(clase) {
        const form = document.getElementById('formEditarClase');
        form.action = `/clases/${clase.IdClase}`;

        for (const [key, value] of Object.entries(clase)) {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = value;
            }
        }
    }
</script>
@endsection