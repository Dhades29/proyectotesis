<div class="col-md-6">
    <label for="IdMateria" class="form-label">Materia</label>
    <select name="IdMateria" id="IdMateria" class="form-select" required>
        <option value="">Seleccione una materia</option>
        @foreach ($materias as $materia)
            <option value="{{ $materia->IdMateria }}">{{ $materia->Nombre }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label for="IdDocente" class="form-label">Docente</label>
    <select name="IdDocente" id="IdDocente" class="form-select" required>
        <option value="">Seleccione un docente</option>
        @foreach ($docentes as $docente)
            <option value="{{ $docente->IdDocente }}">{{ $docente->Nombre }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label for="IdCiclo" class="form-label">Ciclo</label>
    <select name="IdCiclo" id="IdCiclo" class="form-select" required>
        <option value="">Seleccione un ciclo</option>
        @foreach ($ciclos as $ciclo)
            <option value="{{ $ciclo->IdCiclo }}">{{ $ciclo->Anio }} - {{ $ciclo->Periodo }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-6">
    <label for="IdCatedra" class="form-label">Cátedra</label>
    <select name="IdCatedra" id="IdCatedra" class="form-select" required>
        <option value="">Seleccione una cátedra</option>
        @foreach ($catedras as $catedra)
            <option value="{{ $catedra->IdCatedra }}">{{ $catedra->NombreCatedra }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-4">
    <label for="Seccion" class="form-label">Sección</label>
    <input type="text" name="Seccion" id="Seccion" class="form-control" required>
</div>

<div class="col-md-4">
    <label for="Aula" class="form-label">Aula</label>
    <input type="text" name="Aula" id="Aula" class="form-control" required>
</div>

<div class="col-md-4">
    <label for="Edificio" class="form-label">Edificio</label>
    <input type="text" name="Edificio" id="Edificio" class="form-control" required>
</div>

<div class="col-md-6">
    <label for="DiaSemana" class="form-label">Día de la Semana</label>
    <select name="DiaSemana" id="DiaSemana" class="form-select" required>
        <option value="">Seleccione un día</option>
        <option value="Lunes">Lunes</option>
        <option value="Martes">Martes</option>
        <option value="Miércoles">Miércoles</option>
        <option value="Jueves">Jueves</option>
        <option value="Viernes">Viernes</option>
        <option value="Sábado">Sábado</option>
    </select>
</div>

<div class="col-md-3">
    <label for="HoraInicio" class="form-label">Hora de Inicio</label>
    <input type="time" name="HoraInicio" id="HoraInicio" class="form-control" required>
</div>

<div class="col-md-3">
    <label for="HoraFin" class="form-label">Hora de Fin</label>
    <input type="time" name="HoraFin" id="HoraFin" class="form-control" required>
</div>

<div class="col-md-3">
    <label for="Inscritos" class="form-label">Inscritos</label>
    <input type="number" name="Inscritos" id="Inscritos" class="form-control" required min="0">
</div>