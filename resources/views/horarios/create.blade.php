@extends('layouts.app')

@section('title', 'Asignar Horario')

@section('content')
<div class="container-fluid px-0 py-2">
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-3">
            <i class="fas fa-check-circle fa-lg me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-3">
            <i class="fas fa-exclamation-circle fa-lg me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Asignar Horario, Aula y Materia</h4>
                    <p class="mb-0 text-white-50 small mt-1">Planificación y distribución horaria académica para la facultad</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('horarios.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Grupo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-layer-group"></i></span>
                            <select name="grupo_id" class="form-select border font-size-sm" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }} ({{ $grupo->codigo }}) - {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }} estudiantes</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Materia <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-book"></i></span>
                            <select name="materia_id" class="form-select border font-size-sm" required>
                                <option value="">Seleccione una materia</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Docente <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-chalkboard-teacher"></i></span>
                            <select name="docente_id" class="form-select border font-size-sm" required>
                                <option value="">Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">{{ $docente->nombre_completo }} - {{ $docente->especialidad }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Aula <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-school"></i></span>
                            <select name="aula_id" class="form-select border font-size-sm" required>
                                <option value="">Seleccione un aula</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}">{{ $aula->nombre }} (Capacidad: {{ $aula->capacidad }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label class="form-label text-dark fw-medium small">Día <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-calendar-day"></i></span>
                            <select name="dia" class="form-select border font-size-sm" required>
                                <option value="">Seleccione un día</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label class="form-label text-dark fw-medium small">Hora Inicio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-clock"></i></span>
                            <input type="time" name="hora_inicio" class="form-control border font-size-sm" required>
                        </div>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label class="form-label text-dark fw-medium small">Hora Fin <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-history"></i></span>
                            <input type="time" name="hora_fin" class="form-control border font-size-sm" required>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom my-4 d-flex align-items-center p-3">
                    <i class="fas fa-info-circle fa-lg me-2.5"></i>
                    <span class="small fw-medium"><strong>Nota:</strong> Un docente puede ser asignado a un máximo de 4 grupos según la reglamentación interna de la facultad.</span>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary border-0 font-size-sm px-4 py-2 rounded-3">Cancelar</a>
                    <button type="submit" class="btn btn-action font-size-sm px-4 py-2 rounded-3 fw-bold shadow-sm hover-up">
                        <i class="fas fa-save me-1"></i> Asignar Horario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3 d-flex align-items-center" style="background-color: #17a2b8;">
            <i class="fas fa-list text-white me-2 opacity-75"></i>
            <h5 class="mb-0 fw-bold text-white">Horarios Asignados</h5>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">Grupo</th>
                            <th class="py-3">Materia</th>
                            <th class="py-3">Docente</th>
                            <th class="py-3">Aula</th>
                            <th class="py-3 text-center">Día</th>
                            <th class="py-3 text-center">Hora Inicio</th>
                            <th class="py-3 text-center">Hora Fin</th>
                            <th class="py-3 text-center px-3" style="width: 110px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $horarios = \App\Models\Horario::with(['grupo', 'materia', 'docente', 'aula'])->get();
                        @endphp
                        @forelse($horarios as $horario)
                            <tr class="row-hover-effect">
                                <td class="px-3 fw-bold text-dark">{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                                <td><span class="badge bg-light text-dark border font-size-xs px-2 py-1.5">{{ $horario->materia->nombre ?? 'N/A' }}</span></td>
                                <td class="text-secondary fw-medium font-size-sm">{{ $horario->docente->nombre_completo ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary-soft text-primary-custom px-2 py-1.5 font-size-xs border border-primary border-opacity-10 fw-semibold">
                                        <i class="fas fa-door-open me-1"></i>{{ $horario->aula->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center"><span class="badge bg-info-soft text-info-custom px-2 py-1 rounded fw-semibold">{{ $horario->dia }}</span></td>
                                <td class="text-center text-dark font-monospace fw-medium">{{ $horario->hora_inicio }}</td>
                                <td class="text-center text-dark font-monospace fw-medium">{{ $horario->hora_fin }}</td>
                                <td class="text-center px-3">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-outline-warning border-0 rounded-3 action-icon-btn" title="Editar">
                                            <i class="fas fa-edit text-warning-custom"></i>
                                        </a>
                                        <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-3 action-icon-btn" onclick="return confirm('¿Eliminar este horario?')" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-light bg-opacity-50">
                                    <div class="py-2">
                                        <i class="fas fa-calendar-times text-muted fa-2x mb-2 opacity-40"></i>
                                        <h6 class="text-muted fw-normal mb-0">No hay horarios asignados aún en la base de datos</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estilos de cabeceras de tablas e iconos */
    .custom-table-header {
        background-color: #0a2b5e !important;
    }
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Efecto Hover para filas */
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Badges translúcidos */
    .bg-primary-soft {
        background-color: rgba(10, 43, 94, 0.08);
    }
    .bg-info-soft {
        background-color: rgba(23, 162, 184, 0.12);
    }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }
    .text-warning-custom { color: #d39e00; }

    /* Estilizado de botones icónicos dentro de tablas */
    .action-icon-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .action-icon-btn:hover {
        transform: scale(1.15);
        background-color: rgba(0, 0, 0, 0.05) !important;
    }

    /* Clases utilitarias */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    
    .btn-action {
        background-color: #0a2b5e;
        color: white;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush
@endsection