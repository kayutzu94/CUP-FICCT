@extends('layouts.app')

@section('title', 'Asignar Horario')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Asignar Horario, Aula y Materia</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('horarios.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Grupo <span class="text-danger">*</span></label>
                    <select name="grupo_id" class="form-control" required>
                        <option value="">Seleccione un grupo</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }} ({{ $grupo->codigo }}) - {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }} estudiantes</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Materia <span class="text-danger">*</span></label>
                    <select name="materia_id" class="form-control" required>
                        <option value="">Seleccione una materia</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Docente <span class="text-danger">*</span></label>
                    <select name="docente_id" class="form-control" required>
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->nombre_completo }} - {{ $docente->especialidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Aula <span class="text-danger">*</span></label>
                    <select name="aula_id" class="form-control" required>
                        <option value="">Seleccione un aula</option>
                        @foreach($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->nombre }} (Capacidad: {{ $aula->capacidad }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Día <span class="text-danger">*</span></label>
                    <select name="dia" class="form-control" required>
                        <option value="">Seleccione un día</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miércoles">Miércoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Hora Inicio <span class="text-danger">*</span></label>
                    <input type="time" name="hora_inicio" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Hora Fin <span class="text-danger">*</span></label>
                    <input type="time" name="hora_fin" class="form-control" required>
                </div>
            </div>

            <div class="alert alert-info">
                <strong>Nota:</strong> Un docente puede ser asignado a máximo 4 grupos según las reglas de la facultad.
            </div>

            <div class="text-end">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Asignar Horario</button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h4>Horarios Asignados</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Grupo</th>
                        <th>Materia</th>
                        <th>Docente</th>
                        <th>Aula</th>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $horarios = \App\Models\Horario::with(['grupo', 'materia', 'docente', 'aula'])->get();
                    @endphp
                    @forelse($horarios as $horario)
                        <tr>
                            <td>{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                            <td>{{ $horario->materia->nombre ?? 'N/A' }}</td>
                            <td>{{ $horario->docente->nombre_completo ?? 'N/A' }}</td>
                            <td>{{ $horario->aula->nombre ?? 'N/A' }}</td>
                            <td>{{ $horario->dia }}</td>
                            <td>{{ $horario->hora_inicio }}</td>
                            <td>{{ $horario->hora_fin }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay horarios asignados aún</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection