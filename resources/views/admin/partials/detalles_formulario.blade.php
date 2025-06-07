<div class="card">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
    <strong>{{ $formulario->NombreFormulario }}</strong>
    <button type="button" class="btn btn-sm btn-light text-danger" onclick="cerrarDetallesFormulario()">
        <i class="fa fa-times"></i>
    </button>
</div>
    <div class="card-body">
        @foreach($secciones as $seccion)
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