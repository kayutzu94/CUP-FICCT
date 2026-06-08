@extends('layouts.app')

@section('title', 'Editar Horario')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h4>Editar Horario</h4>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('horarios.update', $horario) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Grupo <span class="text-danger">*</span></label>
                    <select name="grupo_id" class="form-control" required>
                        <option value="">Seleccione un grupo</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}" {{ $horario->grupo_id == $grupo->id ? 'selected' : '' }}>
                                {{ $grupo->nombre }} ({{ $grupo->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Materia <span class="text-danger">*</span></label>
                    <select name="materia_id" class="form-control" required>
                        <option value="">Seleccione una materia</option>
                        @foreach($materias as $materia)
                            <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                {{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Docente <span class="text-danger">*</span></label>
                    <select name="docente_id" class="form-control" required>
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ $horario->docente_id == $docente->id ? 'selected' : '' }}>
                                {{ $docente->nombre_completo }} - {{ $docente->especialidad }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Aula <span class="text-danger">*</span></label>
                    <select name="aula_id" class="form-control" required>
                        <option value="">Seleccione un aula</option>
                        @foreach($aulas as $aula)
                            <option value="{{ $aula->id }}" {{ $horario->aula_id == $aula->id ? 'selected' : '' }}>
                                {{ $aula->nombre }} (Capacidad: {{ $aula->capacidad }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Día <span class="text-danger">*</span></label>
                    <select name="dia" class="form-control" required>
                        <option value="">Seleccione un día</option>
                        <option value="Lunes" {{ $horario->dia == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                        <option value="Martes" {{ $horario->dia == 'Martes' ? 'selected' : '' }}>Martes</option>
                        <option value="Miércoles" {{ $horario->dia == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                        <option value="Jueves" {{ $horario->dia == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                        <option value="Viernes" {{ $horario->dia == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Hora Inicio <span class="text-danger">*</span></label>
                    <input type="time" name="hora_inicio" class="form-control" value="{{ $horario->hora_inicio }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Hora Fin <span class="text-danger">*</span></label>
                    <input type="time" name="hora_fin" class="form-control" value="{{ $horario->hora_fin }}" required>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('horarios.create') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Horario</button>
            </div>
        </form>
    </div>
</div>
@endsection