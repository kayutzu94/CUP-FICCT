@extends('layouts.app')

@section('title', 'Mi Carga Horaria')

@section('header', 'Mi Carga Horaria')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-clock fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Distribución de Carga Horaria</h4>
                    <p class="mb-0 text-white-50 small mt-1">Cronograma oficial de períodos académicos, asignación de materias y ubicación de infraestructura</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if($cargaHoraria->isEmpty())
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom text-center py-5 mb-0 shadow-2xs">
                    <div class="indicator-circle-bg bg-white bg-opacity-50 text-primary-custom mx-auto mb-3 shadow-3xs" style="width: 52px; height: 52px; font-size: 1.3rem;">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h5 class="fw-bold text-dark font-size-md">Sin asignaciones registradas</h5>
                    <p class="text-secondary small mb-0 max-width-text mx-auto mt-1">Actualmente no dispones de horarios configurados en el sistema académico para el período actual.</p>
                </div>
            @else
                <div class="table-responsive rounded-3 border bg-white shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="custom-table-header text-white">
                            <tr>
                                <th class="py-3 px-3" style="width: 140px;">Día de Clase</th>
                                <th class="text-center py-3" style="width: 130px;">Hora Inicio</th>
                                <th class="text-center py-3" style="width: 130px;">Hora Fin</th>
                                <th class="text-center py-3" style="width: 120px;">Grupo</th>
                                <th class="py-3">Materia / Asignatura</th>
                                <th class="py-3" style="width: 180px;">Aula / Espacio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cargaHoraria as $horario)
                            <tr class="row-hover-effect">
                                <td class="px-3 fw-bold text-dark font-size-sm">
                                    <i class="far fa-calendar-alt text-muted me-2 font-size-xs"></i>{{ $horario->dia }}
                                </td>
                                
                                <td class="text-center font-monospace font-size-sm fw-medium text-secondary">
                                    {{ $horario->hora_inicio }}
                                </td>
                                
                                <td class="text-center font-monospace font-size-sm fw-medium text-secondary">
                                    {{ $horario->hora_fin }}
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-primary-soft text-primary-custom px-2.5 py-1.5 rounded-3 font-size-xs fw-bold border border-primary border-opacity-10 d-block mx-auto" style="max-width: 80px;">
                                        {{ $horario->grupo->nombre ?? 'N/A' }}
                                    </span>
                                </td>
                                
                                <td class="fw-semibold font-size-sm text-dark">
                                    {{ $horario->materia->nombre ?? 'N/A' }}
                                </td>
                                
                                <td class="font-size-sm text-secondary">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt font-size-xs text-muted opacity-75 me-2"></i>
                                        <span>{{ $horario->aula->nombre ?? 'N/A' }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras visuales fijas e institucionales */
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

    /* Esquemas cromáticos suaves */
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .text-primary-custom { color: #0a2b5e; }

    .indicator-circle-bg {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Clases utilitarias y tipografías */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .max-width-text { max-width: 450px; }
</style>
@endpush