
<div class="container" style="text-align:right;">
    <button type="button" onclick="cerrarEdicionFormulario()" style="position:fixed; background:none; border:none; font-size:1.5rem; cursor:pointer;" title="Cerrar edición">&times;</button>
</div>
<div class="container">

    <div id="secciones-container">
        @foreach($secciones as $seccionIndex => $seccion)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <input type="text" name="secciones[{{ $seccionIndex }}][Titulo]" value="{{ $seccion->Titulo }}" class="form-control" placeholder="Nombre de la sección" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarSeccion(this)">Eliminar Sección</button>
                </div>
                <div class="card-body" id="preguntas-{{ $seccionIndex }}">
                    @foreach($seccion->preguntas as $preguntaIndex => $pregunta)
                        <div class="card p-3 border border-primary mb-2">
                            <div class="mb-2">
                                <label class="form-label">Pregunta</label>
                                <input type="text" name="secciones[{{ $seccionIndex }}][preguntas][{{ $preguntaIndex }}][Texto]" value="{{ $pregunta->Texto }}" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Tipo de Respuesta</label>
                                <select name="secciones[{{ $seccionIndex }}][preguntas][{{ $preguntaIndex }}][TipoRespuesta]" class="form-select"
                                        onchange="actualizarTipoRespuesta({{ $seccionIndex }}, {{ $preguntaIndex }}, this.value)">
                                    <option value="">-- Seleccionar tipo --</option>
                                    <option value="texto" {{ $pregunta->TipoRespuesta == 'texto' ? 'selected' : '' }}>Texto</option>
                                    <option value="seleccion" {{ $pregunta->TipoRespuesta == 'seleccion' ? 'selected' : '' }}>Selección Única</option>
                                    <option value="multiple" {{ $pregunta->TipoRespuesta == 'multiple' ? 'selected' : '' }}>Selección Múltiple</option>
                                    <option value="booleano" {{ $pregunta->TipoRespuesta == 'booleano' ? 'selected' : '' }}>Sí / No</option>
                                </select>
                            </div>
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" id="obligatoria-{{ $seccionIndex }}-{{ $preguntaIndex }}"
                                    name="secciones[{{ $seccionIndex }}][preguntas][{{ $preguntaIndex }}][EsObligatoria]" value="1"
                                    {{ $pregunta->EsObligatoria ? 'checked' : '' }}>
                                <label class="form-check-label" for="obligatoria-{{ $seccionIndex }}-{{ $preguntaIndex }}">
                                    ¿Es obligatoria?
                                </label>
                            </div>
                            <div class="tipo-respuesta mt-2" id="respuesta-{{ $seccionIndex }}-{{ $preguntaIndex }}">
                                @if($pregunta->TipoRespuesta == 'texto')
                                    <input type="text" class="form-control" disabled placeholder="Respuesta de texto...">
                                @elseif($pregunta->TipoRespuesta == 'booleano')
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" disabled>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" disabled>
                                        <label class="form-check-label">No</label>
                                    </div>
                                @elseif($pregunta->TipoRespuesta == 'seleccion' || $pregunta->TipoRespuesta == 'multiple')
                                    @php $tipoInput = $pregunta->TipoRespuesta == 'seleccion' ? 'radio' : 'checkbox'; @endphp
                                    <div id="opciones-{{ $seccionIndex }}-{{ $preguntaIndex }}" class="mb-2 d-flex flex-column gap-2">
                                        @foreach($pregunta->opciones as $opcionIndex => $opcion)
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <input type="{{ $tipoInput }}" disabled>
                                                </div>
                                                <input type="text" name="secciones[{{ $seccionIndex }}][preguntas][{{ $preguntaIndex }}][opciones][{{ $opcionIndex }}]" value="{{ $opcion->Texto }}" class="form-control" required>
                                                <button class="btn btn-outline-danger" type="button" onclick="this.closest('.input-group').remove()">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                        onclick="agregarOpcion({{ $seccionIndex }}, {{ $preguntaIndex }}, '{{ $tipoInput }}')">
                                        <i class="fa fa-plus-circle"></i> Agregar Opción
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary mt-2" onclick="agregarPregunta({{ $seccionIndex }})">
                    <i class="fa fa-plus"></i> Agregar Pregunta
                </button>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-success me-3" onclick="agregarSeccion()">
        <i class="fa fa-plus"></i> Agregar Sección
    </button>
    <!-- Botón Cancelar fijo en la esquina inferior derecha -->
    <button type="button" class="btn btn-secondary " id="btn-cancelar-edicion" onclick="cerrarEdicionFormulario()">
        Cancelar
    </button>

</div>

<script>
    
function agregarSeccion() {
    const seccionesContainer = document.getElementById('secciones-container');
    const indexSeccion = seccionesContainer.childElementCount;
    const seccionHTML = `
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <input type="text" name="secciones[${indexSeccion}][nombre]" class="form-control" placeholder="Nombre de la sección" required>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarSeccion(this)">Eliminar Sección</button>
            </div>
            <div class="card-body" id="preguntas-${indexSeccion}"></div>
            <button type="button" class="btn btn-primary mt-2" onclick="agregarPregunta(${indexSeccion})">
                <i class="fa fa-plus"></i> Agregar Pregunta
            </button>
        </div>
    `;
    seccionesContainer.insertAdjacentHTML('beforeend', seccionHTML);
}

function eliminarSeccion(btn) {
    btn.closest('.card').remove();
}

</script>
