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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                @if(isset($formularioSeleccionado) && isset($seccionesSeleccionadas))
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <strong>{{ $formularioSeleccionado->NombreFormulario }}</strong>
                    </div>
                    <div class="card-body">
                        @foreach($seccionesSeleccionadas as $seccion)
                            <div class="mb-3">
                                <h5 class="text-primary">{{ $seccion->Titulo }}</h5>
                                <ol>
                                    @foreach($seccion->preguntas as $pregunta)
                                        <li class="mb-2">
                                            <div>
                                                <strong>{{ $pregunta->Texto }}</strong>
                                                <span class="badge bg-secondary">{{ ucfirst($pregunta->TipoRespuesta) }}</span>
                                                @if($pregunta->EsObligatoria)
                                                    <span class="badge bg-danger">Obligatoria</span>
                                                @endif
                                            </div>
                                            @if(count($pregunta->opciones))
                                                <ul>
                                                    @foreach($pregunta->opciones as $opcion)
                                                        <li>{{ $opcion->Texto }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    Selecciona un formulario para ver sus detalles.
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar formulario -->
<div class="modal fade" id="modalEditarFormulario" tabindex="-1" aria-labelledby="modalEditarFormularioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formularioEditar" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" onclick="limpiarModalEditarFormulario()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editarNombreFormulario" class="form-label">Nombre del Formulario</label>
                        <input type="text" class="form-control" id="editarNombreFormulario" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-success" id="btnEditarAgregarSeccion">
                            <i class="fa fa-plus-circle"></i> Agregar Sección
                        </button>
                    </div>
                    <div id="editarContenedorSecciones" class="d-flex flex-column gap-4">
                        <!-- Secciones dinámicas para edición -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
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

    function verDetallesFormulario(idFormulario) {
        fetch(`/formularios/${idFormulario}/detalles`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detallesFormulario').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('detallesFormulario').innerHTML = '<div class="alert alert-danger">No se pudieron cargar los detalles.</div>';
            });
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

    // Abre el modal y carga los datos del formulario a editar
    function editarFormulario(idFormulario) {
        fetch(`/formularios/${idFormulario}/detalles`)
            .then(response => response.json())
            .then(data => {
                // Limpia el modal
                limpiarModalEditarFormulario();

                // Llena el nombre
                document.getElementById('editarNombreFormulario').value = data.formulario.NombreFormulario;

                // Llena las secciones y preguntas
                const contenedor = document.getElementById('editarContenedorSecciones');
                contadorEditarSecciones = 0;
                data.secciones.forEach((seccion, idxSeccion) => {
                    contadorEditarSecciones++;
                    const idSeccion = `editar-seccion-${contadorEditarSecciones}`;
                    let seccionHTML = `
                        <div class="card border border-success p-3" id="${idSeccion}">
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Sección</label>
                                <input type="text" name="secciones[${contadorEditarSecciones}][titulo]" class="form-control" required value="${seccion.Titulo}">
                            </div>
                            <div class="preguntas-container d-flex flex-column gap-3" id="editar-preguntas-${contadorEditarSecciones}"></div>
                            <button type="button" class="btn btn-outline-primary mt-2" onclick="editarAgregarPregunta(${contadorEditarSecciones})">
                                <i class="fa fa-plus"></i> Agregar Pregunta
                            </button>
                        </div>
                    `;
                    contenedor.insertAdjacentHTML('beforeend', seccionHTML);

                    // Agrega preguntas existentes
                    seccion.preguntas.forEach((pregunta, idxPregunta) => {
                        editarAgregarPregunta(contadorEditarSecciones, pregunta, idxPregunta);
                    });
                });

                // Setea la acción del formulario
                document.getElementById('formularioEditar').action = `/formularios/${idFormulario}`;
                // Muestra el modal
                var modal = new bootstrap.Modal(document.getElementById('modalEditarFormulario'));
                modal.show();
            })
            .catch(() => {
                alert('No se pudieron cargar los datos del formulario.');
            });
    }

    function editarAgregarPregunta(seccionId, preguntaObj = null, idxPregunta = null) {
        const contenedorPreguntas = document.getElementById(`editar-preguntas-${seccionId}`);
        const indexPregunta = idxPregunta !== null ? idxPregunta : contenedorPreguntas.childElementCount;

        let texto = preguntaObj ? preguntaObj.Texto : '';
        let tipo = preguntaObj ? preguntaObj.TipoRespuesta : '';
        let esObligatoria = preguntaObj && preguntaObj.EsObligatoria ? 'checked' : '';
        let opciones = preguntaObj && preguntaObj.opciones ? preguntaObj.opciones : [];

        let preguntaHTML = `
            <div class="card p-3 border border-primary">
                <div class="mb-2">
                    <label class="form-label">Pregunta</label>
                    <input type="text" name="secciones[${seccionId}][preguntas][${indexPregunta}][texto]" class="form-control" required value="${texto}">
                </div>
                <div class="mb-2">
                    <label class="form-label">Tipo de Respuesta</label>
                    <select name="secciones[${seccionId}][preguntas][${indexPregunta}][tipo]" class="form-select"
                            onchange="editarActualizarTipoRespuesta(${seccionId}, ${indexPregunta}, this.value)">
                        <option value="">-- Seleccionar tipo --</option>
                        <option value="texto" ${tipo === 'texto' ? 'selected' : ''}>Texto</option>
                        <option value="seleccion" ${tipo === 'seleccion' ? 'selected' : ''}>Selección Única</option>
                        <option value="multiple" ${tipo === 'multiple' ? 'selected' : ''}>Selección Múltiple</option>
                        <option value="booleano" ${tipo === 'booleano' ? 'selected' : ''}>Sí / No</option>
                    </select>
                </div>
                <div class="mb-2 form-check">
                    <input type="checkbox" class="form-check-input" id="editar-obligatoria-${seccionId}-${indexPregunta}"
                        name="secciones[${seccionId}][preguntas][${indexPregunta}][es_obligatoria]" value="1" ${esObligatoria}>
                    <label class="form-check-label" for="editar-obligatoria-${seccionId}-${indexPregunta}">
                        ¿Es obligatoria?
                    </label>
                </div>
                <div class="tipo-respuesta mt-2" id="editar-respuesta-${seccionId}-${indexPregunta}"></div>
            </div>
        `;
        contenedorPreguntas.insertAdjacentHTML('beforeend', preguntaHTML);

        // Si hay tipo, renderiza las opciones
        if (tipo) {
            editarActualizarTipoRespuesta(seccionId, indexPregunta, tipo, opciones);
        }
    }

    // Actualiza el tipo de respuesta en edición
    function editarActualizarTipoRespuesta(seccionId, preguntaId, tipo, opciones = []) {
        const contenedorRespuesta = document.getElementById(`editar-respuesta-${seccionId}-${preguntaId}`);
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
                <div id="editar-opciones-${seccionId}-${preguntaId}" class="mb-2 d-flex flex-column gap-2"></div>
                <button type="button" class="btn btn-sm btn-outline-secondary"
                    onclick="editarAgregarOpcion(${seccionId}, ${preguntaId}, '${tipoInput}')">
                    <i class="fa fa-plus-circle"></i> Agregar Opción
                </button>
            `;
            // Si hay opciones, agrégalas
            if (opciones.length > 0) {
                opciones.forEach((opcion, idxOpcion) => {
                    editarAgregarOpcion(seccionId, preguntaId, tipoInput, opcion.Texto, idxOpcion);
                });
            } else {
                editarAgregarOpcion(seccionId, preguntaId, tipoInput);
            }
        }
    }

    // Agrega una opción en modo edición (si textoOpcion es null, es nueva)
    function editarAgregarOpcion(seccionId, preguntaId, tipoInput, textoOpcion = '', idxOpcion = null) {
        const contenedor = document.getElementById(`editar-opciones-${seccionId}-${preguntaId}`);
        const indexOpcion = idxOpcion !== null ? idxOpcion : contenedor.childElementCount;

        const opcionHTML = `
            <div class="input-group">
                <div class="input-group-text">
                    <input type="${tipoInput}" disabled>
                </div>
                <input type="text" name="secciones[${seccionId}][preguntas][${preguntaId}][opciones][${indexOpcion}]" class="form-control" required value="${textoOpcion}">
                <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;
        contenedor.insertAdjacentHTML('beforeend', opcionHTML);
    }

    // Limpia el modal de edición
    function limpiarModalEditarFormulario() {
        document.getElementById('formularioEditar').reset();
        document.getElementById('editarContenedorSecciones').innerHTML = '';
        contadorEditarSecciones = 0;
    }


</script>

@endsection