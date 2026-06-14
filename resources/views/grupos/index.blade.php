@extends('layouts.app')

@section('title', 'Grupos')

@section('content')
<div class="container-fluid px-0 py-2">
    
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 metric-card text-white" style="background: linear-gradient(135deg, #0a2b5e 0%, #143f7d 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 small mb-1 fw-bold text-uppercase tracking-wider">Total Inscritos</p>
                        <h2 class="mb-0 fw-bold font-monospace">{{ $totalInscritos }}</h2>
                    </div>
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 metric-card text-white" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 small mb-1 fw-bold text-uppercase tracking-wider">Grupos Necesarios</p>
                        <h2 class="mb-0 fw-bold font-monospace">{{ $gruposNecesarios }}</h2>
                        <small class="text-white-50 font-size-xs d-block mt-1 italic">Fórmula: CEIL({{ $totalInscritos }}/70)</small>
                    </div>
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-calculator fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 metric-card text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-white-50 small mb-1 fw-bold text-uppercase tracking-wider">Grupos Creados</p>
                        <h2 class="mb-0 fw-bold font-monospace">{{ $grupos->count() }}</h2>
                    </div>
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3">
                        <i class="fas fa-layer-group fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3.5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div>
                <h4 class="mb-0 fw-bold text-white d-flex align-items-center">
                    <i class="fas fa-layer-group me-2 opacity-75"></i> Gestión de Grupos
                </h4>
                <p class="mb-0 text-white-50 small mt-1">Distribución y asignación de aulas para el CUP FICCT</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('grupos.asignar-automatico') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-success fw-bold text-white rounded-3 px-3 shadow-sm hover-up w-100 w-sm-auto" onclick="return confirm('¿Asignar automáticamente todos los estudiantes?')">
                        <i class="fas fa-magic me-1"></i> Asignar Automáticamente
                    </button>
                </form>
                <button class="btn btn-warning fw-bold text-dark rounded-3 px-3 shadow-sm hover-up w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#crearGrupoModal">
                    <i class="fas fa-plus me-1"></i> Crear Grupo
                </button>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach($grupos as $grupo)
                @php 
                    $porcentaje = ($grupo->capacidad_maxima > 0) ? ($grupo->estudiantes_actuales / $grupo->capacidad_maxima) * 100 : 0;
                    $barColor = 'bg-primary';
                    if($porcentaje >= 90) $barColor = 'bg-danger';
                    elseif($porcentaje >= 75) $barColor = 'bg-warning text-dark';
                @endphp
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden group-item-card transition-all">
                        
                        <div class="card-header border-0 py-3 px-3 text-white d-flex justify-content-between align-items-start" style="background-color: #0a2b5e;">
                            <div>
                                <h5 class="mb-0 fw-bold font-size-md text-truncate" style="max-width: 150px;">{{ $grupo->nombre }}</h5>
                                <small class="text-white-50 font-monospace font-size-xs">{{ $grupo->codigo }}</small>
                            </div>
                            <span class="badge bg-white bg-opacity-10 font-size-xs px-2 py-1 rounded fw-bold" style="color: #ffc107 !important;">CUP</span>
                        </div>
                        
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1.5">
                                    <small class="text-muted fw-medium font-size-xs">Ocupación</small>
                                    <small class="fw-bold font-size-xs text-dark">{{ $grupo->estudiantes_actuales }} / {{ $grupo->capacidad_maxima }}</small>
                                </div>
                                
                                <div class="progress rounded-pill mb-3" style="height: 10px;">
                                    <div class="progress-bar {{ $barColor }} progress-bar-striped progress-bar-animated rounded-pill" 
                                         role="progressbar" 
                                         style="width: {{ $porcentaje }}%">
                                    </div>
                                </div>
                                
                                <p class="text-muted small mb-0 d-flex align-items-center">
                                    <i class="fas fa-users text-primary-custom me-2 font-size-sm"></i>
                                    <span>Alumnos: <strong class="text-dark font-monospace">{{ $grupo->estudiantes_actuales }}</strong></span>
                                </p>
                            </div>
                            
                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('grupos.show', $grupo) }}" class="btn btn-sm btn-outline-primary border rounded-3 px-2 py-1.5 flex-fill d-flex align-items-center justify-content-center font-size-sm fw-medium">
                                    <i class="fas fa-eye me-1"></i> Ver Alumnos
                                </a>
                                <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border rounded-3 px-2 py-1.5 w-100 d-flex align-items-center justify-content-center font-size-sm fw-medium" onclick="return confirm('¿Está seguro de eliminar este grupo?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($grupos->isEmpty())
                <div class="text-center py-5 bg-white rounded-3 border">
                    <i class="fas fa-folder-open text-muted fa-3x mb-3 opacity-40"></i>
                    <h5 class="text-muted fw-normal">No se han creado grupos todavía</h5>
                    <p class="text-muted small mb-0">Haga clic en "Crear Grupo" o utilice la "Asignación Automática" para iniciar.</p>
                </div>
            @endif

        </div>
    </div>
</div>

<div class="modal fade" id="crearGrupoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header text-white border-0 py-3 px-4" style="background: linear-gradient(135deg, #0a2b5e 0%, #143f7d 100%);">
                <h5 class="modal-title fw-bold d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2"></i> Crear Nuevo Grupo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('grupos.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium small">Código del Grupo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-barcode"></i></span>
                            <input type="text" name="codigo" class="form-control border font-size-sm" placeholder="Ej. INF110-A" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium small">Nombre descriptivo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-font"></i></span>
                            <input type="text" name="nombre" class="form-control border font-size-sm" placeholder="Ej. Grupo A - Introducción" required>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-0 d-flex align-items-center p-3">
                        <i class="fas fa-info-circle fa-lg me-2.5"></i>
                        <span class="small fw-medium">La capacidad máxima estructural está configurada para <strong>70 estudiantes</strong> por aula.</span>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-secondary border-0 font-size-sm px-3 py-2 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-action font-size-sm px-4 py-2 rounded-3 fw-bold">Crear Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .metric-card {
        transition: transform 0.2s;
    }
    .metric-card:hover {
        transform: translateY(-2px);
    }
    .metric-icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .group-item-card {
        border: 1px solid rgba(0,0,0,0.06) !important;
    }
    .group-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }

    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .mb-1.5 { margin-bottom: 0.35rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    
    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

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