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
            <form id="formularioCrear" method="POST" action="{{ route('formularios.store') }}">
                @csrf

                <input type="hidden" name="_method" value="POST" id="metodoFormulario">
                <input type="hidden" name="idFormulario" id="idFormulario">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nuevo Formulario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" onclick="limpiarModalFormulario()"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombreFormulario" class="form-label">Nombre del Formulario</label>
                            <input type="text" class="form-control" id="nombreFormulario" name="nombre" required>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-success" id="btnAgregarSeccion">
                                <i class="fa fa-plus-circle"></i> Agregar Sección
                            </button>
                        </div>

                        <div id="contenedorSecciones" class="d-flex flex-column gap-4">
                            <!-- Secciones dinámicas -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalFormulario()">
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

    <!-- Tabla y detalles -->
    <div class="row">
        <div class="col-md-6">
            <!-- Tabla de formularios -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Formularios Creados
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse($formularios as $formulario)
                                    <tr>
                                        <td>{{ $formulario->IdFormulario }}</td>
                                        <td>{{ $formulario->NombreFormulario }}</td>
                                        <td>{{ \Carbon\Carbon::parse($formulario->FechaCreacion)->format('d/m/Y H:i') }}</td>
                                        <td class="d-flex gap-1">
                                            <button class="btn btn-info btn-sm" onclick="verDetallesFormulario({{ $formulario->IdFormulario }}) ">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm"
                                                    onclick="editarFormulario({{ $formulario->IdFormulario }})">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form method="POST" action="{{ route('formularios.destroy', $formulario->IdFormulario) }}" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este formulario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No hay formularios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Detalles del formulario seleccionado -->
            <div id="detallesFormulario">
                <div id="alertSeleccionaFormulario" class="alert alert-info">
                    Selecciona un formulario para ver sus detalles o editarlo.
                </div>
            </div>
            
            <div id="formularioEdicionContainer" 
                style="display:none; max-height: 80vh; overflow-y: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 1.5rem; margin: 0 auto; width: 100%; max-width: 900px;">
                <!-- Aquí se cargará la vista parcial del formulario de edición -->
            </div>
        </div>
    </div>
</div>

<script>

    let contadorSecciones = 0;

    document.addEventListener('DOMContentLoaded', function () {
        const contenedorSecciones = document.getElementById('contenedorSecciones');
        const btnAgregarSeccion = document.getElementById('btnAgregarSeccion');

        btnAgregarSeccion.addEventListener('click', () => {
            contadorSecciones++;
            const idSeccion = `seccion-${contadorSecciones}`;

            const seccionHTML = `
                <div class="card border border-success p-3" id="${idSeccion}">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Sección</label>
                        <input type="text" name="secciones[${contadorSecciones}][titulo]" class="form-control" required>
                    </div>
                    <div class="preguntas-container d-flex flex-column gap-3" id="preguntas-${contadorSecciones}"></div>
                    <button type="button" class="btn btn-outline-primary mt-2" onclick="agregarPregunta(${contadorSecciones})">
                        <i class="fa fa-plus"></i> Agregar Pregunta
                    </button>
                </div>
            `;

            contenedorSecciones.insertAdjacentHTML('beforeend', seccionHTML);
        });
    });

    //visualizar los detalles de los formularios
    function verDetallesFormulario(idFormulario) {
        // Validación: no permitir si edición está activa
        const edicion = document.getElementById('formularioEdicionContainer');
        if (edicion && edicion.style.display === 'block') {
            mostrarAlertaSuperposicion('No puedes ver los detalles mientras la edición está activa.');
            return;
        }
        // Oculta la alerta al ver detalles
        const alerta = document.getElementById('alertSeleccionaFormulario');
        if (alerta) alerta.style.display = 'none';
        fetch(`/formularios/${idFormulario}/detalles`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detallesFormulario').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('detallesFormulario').innerHTML = '<div class="alert alert-danger">No se pudieron cargar los detalles.</div>';
            });
    }

    function cerrarDetallesFormulario() {
        const detalles = document.getElementById('detallesFormulario');
        detalles.innerHTML = `
            <div id="alertSeleccionaFormulario" class="alert alert-info">
                Selecciona un formulario para ver sus detalles o editarlo.
            </div>
        `;
    }

    function agregarPregunta(seccionId) {
        const contenedorPreguntas = document.getElementById(`preguntas-${seccionId}`);
        const indexPregunta = contenedorPreguntas.childElementCount;

        const preguntaHTML = `
            <div class="card p-3 border border-primary">
                <div class="mb-2">
                    <label class="form-label">Pregunta</label>
                    <input type="text" name="secciones[${seccionId}][preguntas][${indexPregunta}][texto]" class="form-control" required>
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
                <div class="mb-2 form-check">
                    <input type="checkbox" class="form-check-input" id="obligatoria-${seccionId}-${indexPregunta}"
                        name="secciones[${seccionId}][preguntas][${indexPregunta}][es_obligatoria]" value="1">
                    <label class="form-check-label" for="obligatoria-${seccionId}-${indexPregunta}">
                        ¿Es obligatoria?
                    </label>
                </div>
                <div class="tipo-respuesta mt-2" id="respuesta-${seccionId}-${indexPregunta}"></div>
            </div>
        `;

        contenedorPreguntas.insertAdjacentHTML('beforeend', preguntaHTML);
    }

    function actualizarTipoRespuesta(seccionId, preguntaId, tipo) {
        const contenedorRespuesta = document.getElementById(`respuesta-${seccionId}-${preguntaId}`);
        contenedorRespuesta.innerHTML = '';

        if (tipo === 'texto') {
            contenedorRespuesta.innerHTML = `<input type="text" class="form-control" disabled placeholder="Respuesta de texto...">`;
        } else if (tipo === 'booleano') {
            contenedorRespuesta.innerHTML = `
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
                <div id="opciones-${seccionId}-${preguntaId}" class="mb-2 d-flex flex-column gap-2"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary"
                    onclick="agregarOpcion(${seccionId}, ${preguntaId}, '${tipoInput}')">
                    <i class="fa fa-plus-circle"></i> Agregar Opción
                </button>
            `;
            agregarOpcion(seccionId, preguntaId, tipoInput);
        }
    }

    function agregarOpcion(seccionId, preguntaId, tipoInput) {
        const contenedor = document.getElementById(`opciones-${seccionId}-${preguntaId}`);
        const indexOpcion = contenedor.childElementCount;

        const opcionHTML = `
            <div class="input-group">
                <div class="input-group-text">
                    <input type="${tipoInput}" disabled>
                </div>
                <input type="text" name="secciones[${seccionId}][preguntas][${preguntaId}][opciones][${indexOpcion}]" class="form-control" required>
                <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        contenedor.insertAdjacentHTML('beforeend', opcionHTML);
    }

    function limpiarModalFormulario() {
        document.getElementById('formularioCrear').reset();
        document.getElementById('contenedorSecciones').innerHTML = '';
        contadorSecciones = 0;
    }


    function editarFormulario(idFormulario) {
        // Validación: no permitir si detalles está activo
        const detalles = document.getElementById('detallesFormulario');
        // Si detalles tiene algo diferente a la alerta, está activo
        const alerta = document.getElementById('alertSeleccionaFormulario');
        if (detalles && (!alerta || alerta.style.display === 'none' || detalles.innerHTML.trim() !== alerta.outerHTML.trim())) {
            if (document.getElementById('formularioEdicionContainer').style.display !== 'block') {
                mostrarAlertaSuperposicion('No puedes editar mientras los detalles están activos.');
                return;
            }
        }
        // Oculta la alerta al editar
        if (alerta) alerta.style.display = 'none';
        const contenedorEdicion = document.getElementById('formularioEdicionContainer');
        const contenedorDetalles = document.getElementById('detallesFormularios');
        contenedorEdicion.innerHTML = '<div class="text-center p-4"><span class="spinner-border"></span> Cargando...</div>';
        contenedorEdicion.style.display = 'block';
        if (contenedorDetalles) contenedorDetalles.style.display = 'none';

        fetch(`/admin/formularios/${idFormulario}/editar-parcial`)
            .then(response => {
                if (!response.ok) throw new Error('Error al cargar el formulario');
                return response.text();
            })
            .then(html => {
                contenedorEdicion.innerHTML = html;
            })
            .catch(error => {
                contenedorEdicion.innerHTML = `<div class="alert alert-danger">No se pudo cargar el formulario: ${error.message}</div>`;
            });
    }

    function cerrarEdicionFormulario() {
        const contenedorEdicion = document.getElementById('formularioEdicionContainer');
        const contenedorDetalles = document.getElementById('detallesFormularios');
        contenedorEdicion.innerHTML = '';
        contenedorEdicion.style.display = 'none';
        if (contenedorDetalles) contenedorDetalles.style.display = 'block';
        // Muestra la alerta al cerrar edición
        const alerta = document.getElementById('alertSeleccionaFormulario');
        if (alerta) alerta.style.display = 'block';
    }


// Alerta visual para superposición
function mostrarAlertaSuperposicion(mensaje) {
    let alerta = document.getElementById('alerta-superposicion');
    if (!alerta) {
        alerta = document.createElement('div');
        alerta.id = 'alerta-superposicion';
        alerta.className = 'alert alert-warning position-fixed top-0 start-50 translate-middle-x mt-3';
        alerta.style.zIndex = 20000;
        alerta.style.minWidth = '300px';
        document.body.appendChild(alerta);
    }
    alerta.innerText = mensaje;
    alerta.style.display = 'block';
    setTimeout(() => { alerta.style.display = 'none'; }, 2500);
}
</script>

@endsection