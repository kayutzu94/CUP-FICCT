@extends('layouts.app')

@section('title', 'Grupos con Más Aprobados')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-trophy fa-lg text-warning-custom"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Ranking de Grupos con Mayor Aprobación</h4>
                    <p class="mb-0 text-white-50 small mt-1">Clasificación ordenada por rendimiento cuantitativo, volumen de promovidos y tasas efectivas</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 70px;">#</th>
                            <th class="py-3">Grupo Académico</th>
                            <th class="text-center py-3" style="width: 150px;">Total Alumnos</th>
                            <th class="text-center py-3" style="width: 130px;">Aprobados</th>
                            <th class="text-center py-3" style="width: 130px;">Reprobados</th>
                            <th class="py-3 px-3" style="min-width: 190px; width: 240px;">Tasa de Éxito</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $index => $grupo)
                        <tr class="row-hover-effect">
                            <td class="text-center px-3">
                                @if($loop->iteration == 1)
                                    <span class="badge bg-warning bg-opacity-20 text-warning-custom rounded-circle p-2 font-size-sm fw-bold shadow-3xs border border-warning border-opacity-10" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        🥇
                                    </span>
                                @elseif($loop->iteration == 2)
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 font-size-sm fw-bold shadow-3xs" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        🥈
                                    </span>
                                @elseif($loop->iteration == 3)
                                    <span class="badge bg-danger bg-opacity-10 text-orange rounded-circle p-2 font-size-sm fw-bold shadow-3xs" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        🥉
                                    </span>
                                @else
                                    <span class="text-muted font-monospace fw-bold font-size-sm">{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            
                            <td>
                                <div class="fw-bold text-dark font-size-sm">{{ $grupo->nombre }}</div>
                                @if($grupo->codigo)
                                    <span class="badge bg-light text-secondary border font-size-2xs font-monospace mt-1 px-2 py-0.5">ID: {{ $grupo->codigo }}</span>
                                @endif
                            </td>
                            
                            <td class="text-center fw-semibold text-secondary font-monospace font-size-sm">
                                {{ $grupo->total_estudiantes }}
                            </td>
                            
                            <td class="text-center">
                                <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-success border-opacity-10 min-width-counter">
                                    <i class="fas fa-user-check me-1 font-size-2xs"></i>{{ $grupo->aprobados }}
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-danger border-opacity-10 min-width-counter">
                                    <i class="fas fa-user-times me-1 font-size-2xs"></i>{{ $grupo->reprobados }}
                                </span>
                            </td>
                            
                            <td class="px-3">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="progress rounded-pill flex-fill shadow-3xs" style="height: 14px;">
                                        <div class="progress-bar bg-success rounded-pill" 
                                             role="progressbar" 
                                             style="width: {{ $grupo->tasa_aprobacion }}%"
                                             aria-valuenow="{{ $grupo->tasa_aprobacion }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="font-size-xs font-monospace fw-bold text-dark" style="min-width: 48px; text-align: right;">
                                        {{ $grupo->tasa_aprobacion }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras generales institucionales */
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
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Esquemas cromáticos suavizados */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-warning-custom { color: #b78a02 !important; }
    .text-orange { color: #fd7e14 !important; }

    /* Clases de ajuste utilitarias responsivas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .gap-2.5 { gap: 0.65rem; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .min-width-counter { min-width: 65px; display: inline-block; }
</style>
@endpush