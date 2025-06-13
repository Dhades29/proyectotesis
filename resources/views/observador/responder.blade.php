@extends('layouts.menuobservador')

@section('title', 'Responder Formulario')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center mb-4">Responder Formulario</h2>
                
                <form action="{{ route('observador.guardarRespuestas', ['asignacionId' => $asignacion->IdAsignacion]) }}" method="POST">
                    
                    @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5>Por favor corrige los siguientes errores:</h5>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @foreach($secciones as $seccion)
                        <div class="mb-4 p-3 border rounded">
                            <h4 class="mb-3">{{ $seccion['Titulo'] }}</h4>

                            @foreach($seccion['preguntas'] as $pregunta)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        {{ $pregunta['Texto'] }}
                                        @if($pregunta['EsObligatoria'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @php
                                        $tipo = strtolower($pregunta['TipoRespuesta']);
                                    @endphp

                                    {{-- Tipo: Booleano --}}
                                    @if($tipo == 'booleano')
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta['IdPregunta'] }}][opcion]" value="1" required>
                                            <label class="form-check-label">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta['IdPregunta'] }}][opcion]" value="0" required>
                                            <label class="form-check-label">No</label>
                                        </div>

                                    {{-- Tipo: Texto --}}
                                    @elseif($tipo == 'texto')
                                        <input type="text" name="respuestas[{{ $pregunta['IdPregunta'] }}][texto]" class="form-control" @if($pregunta['EsObligatoria']) required @endif>

                                    {{-- Tipo: Selección (Radio) --}}
                                    @elseif($tipo == 'seleccion')
                                        @foreach($pregunta['opciones'] as $opcion)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="respuestas[{{ $pregunta['IdPregunta'] }}][opcion]" value="{{ $opcion['IdOpcion'] }}" required>
                                                <label class="form-check-label">
                                                    {{ $opcion['Texto'] }}
                                                </label>
                                            </div>
                                        @endforeach

                                    {{-- Tipo: Múltiple (Checkbox) --}}
                                    @elseif($tipo == 'multiple')
                                        @foreach($pregunta['opciones'] as $opcion)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="respuestas[{{ $pregunta['IdPregunta'] }}][]" value="{{ $opcion['IdOpcion'] }}">
                                                <label class="form-check-label">
                                                    {{ $opcion['Texto'] }}
                                                </label>
                                            </div>
                                        @endforeach

                                    {{-- Tipo no soportado --}}
                                    @else
                                        <p class="text-danger">Tipo de respuesta no soportado.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar Respuestas</button>
                        
                        <a href="{{ route('observador.inicio') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection