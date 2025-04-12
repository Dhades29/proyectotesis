@extends('layouts.menu')

@section('title', 'Asignar Formularios')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Formularios</h2>
        <!-- Botón para abrir el modal -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoFormulario">
            <i class="fa fa-plus"></i> Nuevo Formulario
        </button>
    </div>

    <!-- Modal para nuevo formulario -->
    <div class="modal fade" id="modalNuevoFormulario" tabindex="-1" aria-labelledby="modalNuevoFormularioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formularioCrear" method="POST" action="#">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nuevo Formulario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id="btnCerrarModal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Nombre del formulario -->
                        <div class="mb-3">
                            <label for="nombreFormulario" class="form-label">Nombre del Formulario</label>
                            <input type="text" class="form-control" id="nombreFormulario" name="nombreFormulario" required>
                        </div>

                        <!-- Botón para agregar pregunta -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="btnAgregarPregunta">
                                <i class="fa fa-plus-circle"></i> Agregar Pregunta
                            </button>
                        </div>

                        <!-- Contenedor de preguntas -->
                        <div id="contenedorPreguntas" class="d-flex flex-column gap-3">
                            <!-- Las preguntas se agregarán dinámicamente aquí -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancelarFormulario" data-bs-dismiss="modal">
                            <i class="fa fa-times-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Guardar Formulario
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Tabla de formularios -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Formularios Disponibles
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se mostraran todos los formularios -->
                            <tr>
                                <td>1</td>
                                <td>Formulario Encuesta</td>
                                <td>2025-04-10</td>
                                <td>Asignado</td>
                                <td><button class="btn btn-sm btn-outline-primary">Ver</button></td>
                            </tr>
                            <!-- ... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Detalles del formulario -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Detalles del Formulario
                </div>
                <div class="card-body">
                    <!-- Aquí se mostrarán los datos del formulario seleccionado -->
                    <h5 class="card-title">Nombre: <span id="nombreFormulario">Formulario Encuesta</span></h5>
                    <p><strong>Descripción:</strong> <span id="descripcionFormulario">Formulario para evaluar satisfacción.</span></p>
                    <p><strong>Fecha de creación:</strong> <span id="fechaFormulario">2025-04-10</span></p>

                    <div class="mt-4">
                        <label for="codigoUsuario" class="form-label">Código de Usuario a asignar</label>
                        <input type="text" class="form-control mb-3" id="codigoUsuario" placeholder="Ej. U00123">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-check-circle"></i> Asignar Formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo formulario -->
<div class="modal fade" id="modalNuevoFormulario" tabindex="-1" aria-labelledby="modalNuevoFormularioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formularioCrear" method="POST" action="#">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Nuevo Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" id="btnCerrarModal"></button>
                </div>

                <div class="modal-body">
                    <!-- Nombre del formulario -->
                    <div class="mb-3">
                        <label for="nombreFormulario" class="form-label">Nombre del Formulario</label>
                        <input type="text" class="form-control" id="nombreFormulario" name="nombreFormulario" required>
                    </div>

                    <!-- Botón para agregar pregunta -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-primary" id="btnAgregarPregunta">
                            <i class="fa fa-plus-circle"></i> Agregar Pregunta
                        </button>
                    </div>

                    <!-- Contenedor de preguntas -->
                    <div id="contenedorPreguntas" class="d-flex flex-column gap-3">
                        <!-- Las preguntas se agregarán dinámicamente aquí -->
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelarFormulario" data-bs-dismiss="modal">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar Formulario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
    const formCrear = document.getElementById('formularioCrear');
    const contenedorPreguntas = document.getElementById('contenedorPreguntas');
    const btnAgregarPregunta = document.getElementById('btnAgregarPregunta');

    btnAgregarPregunta.addEventListener('click', function () {
        const preguntaHTML = `
            <div class="card border border-primary p-3">
                <div class="mb-2">
                    <label class="form-label">Pregunta</label>
                    <input type="text" name="preguntas[]" class="form-control" placeholder="Escribe la pregunta..." required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Tipo de Respuesta</label>
                    <select name="tipos[]" class="form-select">
                        <option value="texto">Texto</option>
                        <option value="seleccion">Selección Múltiple</option>
                        <option value="booleano">Sí / No</option>
                    </select>
                </div>
            </div>
        `;
        contenedorPreguntas.insertAdjacentHTML('beforeend', preguntaHTML);
    });

    // Limpiar el formulario al cerrar o cancelar el modal
    const limpiarModalFormulario = () => {
        formCrear.reset();
        contenedorPreguntas.innerHTML = '';
    };

    // Al cerrar con la X
    document.getElementById('btnCerrarModal').addEventListener('click', limpiarModalFormulario);

    // Al hacer clic en "Cancelar"
    document.getElementById('btnCancelarFormulario').addEventListener('click', limpiarModalFormulario);

    // También puedes limpiar cuando se cierra el modal (extra seguridad)
    const modal = document.getElementById('modalNuevoFormulario');
    modal.addEventListener('hidden.bs.modal', limpiarModalFormulario);
</script>

@endsection