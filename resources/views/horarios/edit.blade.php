@extends('layouts.app')

@section('title', 'Editar Horario')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #b78a02 0%, #e0a800 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-warning-custom shadow-2xs">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Editar Configuración de Horario</h4>
                    <p class="mb-0 text-white-75 small mt-1">Ajuste de asignaciones, docentes y espacios físicos de aula</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 bg-danger bg-opacity-10 text-danger mb-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('horarios.update', $horario) }}">
                @csrf
                @method('PUT')

                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-book-reader text-secondary me-1"></i> Asignación Académica
                </span>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Grupo <span class="text-danger">*</span></label>
                        <select name="grupo_id" class="form-select font-size-sm" required>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $horario->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }} ({{ $grupo->codigo }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Materia <span class="text-danger">*</span></label>
                        <select name="materia_id" class="form-select font-size-sm" required>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Docente <span class="text-danger">*</span></label>
                        <select name="docente_id" class="form-select font-size-sm" required>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}" {{ $horario->docente_id == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombre_completo }} ({{ $docente->especialidad }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Aula <span class="text-danger">*</span></label>
                        <select name="aula_id" class="form-select font-size-sm" required>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}" {{ $horario->aula_id == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }} (Capacidad: {{ $aula->capacidad }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-clock text-secondary me-1"></i> Segmentación Temporal
                </span>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Día <span class="text-danger">*</span></label>
                        <select name="dia" class="form-select font-size-sm" required>
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $d)
                                <option value="{{ $d }}" {{ $horario->dia == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Hora Inicio <span class="text-danger">*</span></label>
                        <input type="time" name="hora_inicio" class="form-control font-size-sm" value="{{ $horario->hora_inicio }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Hora Fin <span class="text-danger">*</span></label>
                        <input type="time" name="hora_fin" class="form-control font-size-sm" value="{{ $horario->hora_fin }}" required>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('horarios.create') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">Cancelar</a>
                    <button type="submit" class="btn btn-warning-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up text-white">
                        <i class="fas fa-save me-1.5 font-size-xs"></i> Actualizar Horario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .btn-warning-custom { background-color: #e0a800; border: none; }
    .btn-warning-custom:hover { background-color: #c69500; }
    .text-warning-custom { color: #b78a02 !important; }
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
</style>
@endpush