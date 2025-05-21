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

                        <!-- Botón para agregar sección -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-success" id="btnAgregarSeccion">
                                <i class="fa fa-plus-circle"></i> Agregar Sección
                            </button>
                        </div>

                        <!-- Contenedor de secciones -->
                        <div id="contenedorSecciones" class="d-flex flex-column gap-4">
                            <!-- Secciones con sus preguntas se agregarán aquí -->
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
    let contadorSecciones = 0;

    const contenedorSecciones = document.getElementById('contenedorSecciones');
    const btnAgregarSeccion = document.getElementById('btnAgregarSeccion');

    btnAgregarSeccion.addEventListener('click', function () {
        contadorSecciones++;
        const idSeccion = `seccion-${contadorSecciones}`;

        const seccionHTML = `
            <div class="card border border-success p-3" id="${idSeccion}">
                <div class="mb-3">
                    <label class="form-label">Nombre de la Sección</label>
                    <input type="text" name="secciones[${contadorSecciones}][titulo]" class="form-control" required placeholder="Ej: Infraestructura Tecnológica del Usuario">
                </div>
                
                <!-- Contenedor de preguntas de esta sección -->
                <div class="preguntas-container d-flex flex-column gap-3" id="preguntas-${contadorSecciones}"></div>

                <!-- Botón para agregar pregunta a esta sección -->
                <button type="button" class="btn btn-outline-primary mt-3" onclick="agregarPregunta(${contadorSecciones})">
                    <i class="fa fa-plus"></i> Agregar Pregunta
                </button>
            </div>
        `;
        contenedorSecciones.insertAdjacentHTML('beforeend', seccionHTML);
    });

    function agregarPregunta(seccionId) {
        const contenedorPreguntas = document.getElementById(`preguntas-${seccionId}`);
        const indexPregunta = contenedorPreguntas.childElementCount;

        const preguntaHTML = `
            <div class="card p-3 border border-primary">
                <div class="mb-2">
                    <label class="form-label">Pregunta</label>
                    <input type="text" name="secciones[${seccionId}][preguntas][${indexPregunta}][texto]" class="form-control" required placeholder="Ej: ¿Los estudiantes tienen acceso...?">
                </div>
                <div class="mb-2">
                    <label class="form-label">Tipo de Respuesta</label>
                    <select name="secciones[${seccionId}][preguntas][${indexPregunta}][tipo]" class="form-select">
                        <option value="texto">Texto</option>
                        <option value="seleccion">Selección Múltiple</option>
                        <option value="booleano">Sí / No</option>
                    </select>
                </div>
            </div>
        `;
        contenedorPreguntas.insertAdjacentHTML('beforeend', preguntaHTML);
    }

    function agregarPregunta(seccionId) {
        const contenedorPreguntas = document.getElementById(`preguntas-${seccionId}`);
        const indexPregunta = contenedorPreguntas.childElementCount;

        const preguntaId = `seccion${seccionId}_pregunta${indexPregunta}`;
        const preguntaHTML = `
            <div class="card p-3 border border-primary" id="${preguntaId}">
                <div class="mb-2">
                    <label class="form-label">Pregunta</label>
                    <input type="text" name="secciones[${seccionId}][preguntas][${indexPregunta}][texto]" class="form-control" required placeholder="Ej: ¿Los estudiantes tienen acceso...?">
                </div>

                <div class="mb-2">
                    <label class="form-label">Tipo de Respuesta</label>
                    <select name="secciones[${seccionId}][preguntas][${indexPregunta}][tipo]" class="form-select" 
                        onchange="actualizarTipoRespuesta(${seccionId}, ${indexPregunta}, this.value)">
                        <option value="">-- Seleccionar tipo --</option>
                        <option value="texto">Texto</option>
                        <option value="seleccion">Selección Única</option>
                        <option value="multiple">Selección Múltiple</option>
                        <option value="booleano">Sí / No</option>
                    </select>
                </div>

                <div class="tipo-respuesta mt-3" id="respuesta-${seccionId}-${indexPregunta}">
                    <!-- Aquí se mostrará la UI de tipo de respuesta -->
                </div>
            </div>
        `;

        contenedorPreguntas.insertAdjacentHTML('beforeend', preguntaHTML);
    }

    function actualizarTipoRespuesta(seccionId, preguntaId, tipo) {
        const contenedorRespuesta = document.getElementById(`respuesta-${seccionId}-${preguntaId}`);
        contenedorRespuesta.innerHTML = ''; // Limpiar contenido previo

        if (tipo === 'texto') {
            contenedorRespuesta.innerHTML = `
                <label class="form-label">Vista de Respuesta</label>
                <input type="text" class="form-control" disabled placeholder="Respuesta de texto...">
            `;
        } else if (tipo === 'booleano') {
            contenedorRespuesta.innerHTML = `
                <label class="form-label">Opciones (no editables)</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" disabled>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" disabled>
                    <label class="form-check-label">No</label>
                </div>
            `;
        } else if (tipo === 'seleccion' || tipo === 'multiple') {
            const tipoInput = tipo === 'seleccion' ? 'radio' : 'checkbox';
            contenedorRespuesta.innerHTML = `
                <label class="form-label">Opciones</label>
                <div id="opciones-${seccionId}-${preguntaId}" class="mb-2 d-flex flex-column gap-2"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="agregarOpcion(${seccionId}, ${preguntaId}, '${tipoInput}')">
                    <i class="fa fa-plus-circle"></i> Agregar Opción
                </button>
            `;
            agregarOpcion(seccionId, preguntaId, tipoInput); // Añadir una opción por defecto
        }
    }

    function agregarOpcion(seccionId, preguntaId, tipoInput) {
        const contenedorOpciones = document.getElementById(`opciones-${seccionId}-${preguntaId}`);
        const indexOpcion = contenedorOpciones.childElementCount;

        const opcionHTML = `
            <div class="input-group">
                <div class="input-group-text">
                    <input type="${tipoInput}" disabled>
                </div>
                <input type="text" name="secciones[${seccionId}][preguntas][${preguntaId}][opciones][${indexOpcion}]" class="form-control" placeholder="Opción ${indexOpcion + 1}" required>
                <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        contenedorOpciones.insertAdjacentHTML('beforeend', opcionHTML);
    }


    // Función para limpiar el formulario
    const formCrear = document.getElementById('formularioCrear');
    const limpiarModalFormulario = () => {
        formCrear.reset();
        contenedorSecciones.innerHTML = '';
        contadorSecciones = 0;
    };

    document.getElementById('btnCerrarModal').addEventListener('click', limpiarModalFormulario);
    document.getElementById('btnCancelarFormulario').addEventListener('click', limpiarModalFormulario);
    document.getElementById('modalNuevoFormulario').addEventListener('hidden.bs.modal', limpiarModalFormulario);
</script>

@endsection