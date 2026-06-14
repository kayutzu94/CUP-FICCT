@extends('layouts.app')

@section('title', 'Listado de Asistencias')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Listado de Asistencias y Puntualidad</h4>
                    <p class="mb-0 text-white-50 small mt-1">Registro cronológico de asistencia, control de ausentismo y estado de presencialidad por grupo académico</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if($asistencias->isEmpty())
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom text-center py-5 mb-0 shadow-2xs">
                    <div class="indicator-circle-bg bg-white bg-opacity-50 text-primary-custom mx-auto mb-3 shadow-3xs" style="width: 52px; height: 52px; font-size: 1.3rem;">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="fw-bold text-dark font-size-md">No se registran hojas de asistencia</h5>
                    <p class="text-secondary small mb-0 max-width-text mx-auto mt-1">Los controles diarios tomados en las aulas compartidas aparecerán listados de forma consolidada en esta sección.</p>
                </div>
            @else
                <div class="table-responsive rounded-3 border bg-white shadow-sm">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="custom-table-header text-white">
                            <tr>
                                <th class="py-3 px-3" style="width: 150px;">Fecha</th>
                                <th class="py-3" style="width: 220px;">Grupo / Módulo</th>
                                <th class="py-3">Estudiante / Postulante</th>
                                <th class="text-center py-3" style="width: 150px;">Estado de Presencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $a)
                            <tr class="row-hover-effect">
                                <td class="px-3 font-monospace font-size-sm text-dark fw-medium">
                                    <i class="far fa-calendar text-muted me-2 font-size-xs"></i>{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-dark font-size-sm">
                                        {{ $a->grupo->nombre ?? 'N/A' }}
                                    </div>
                                    @if(isset($a->grupo->codigo))
                                        <span class="badge bg-light text-secondary border font-size-2xs font-monospace mt-0.5 px-1.5 py-0.2">ID: {{ $a->grupo->codigo }}</span>
                                    @endif
                                </td>
                                
                                <td class="fw-medium font-size-sm text-dark">
                                    {{ $a->postulante->nombre_completo ?? 'N/A' }}
                                </td>
                                
                                <td class="text-center">
                                    @if($a->presente)
                                        <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-success border-opacity-10 min-width-badge d-inline-block">
                                            <i class="fas fa-check-circle me-1.5 font-size-2xs"></i>Presente
                                        </span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-danger border-opacity-10 min-width-badge d-inline-block">
                                            <i class="fas fa-times-circle me-1.5 font-size-2xs"></i>Ausente
                                        </span>
                                    @endif
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

    /* Esquemas suaves para Badges */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
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
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .py-0.2 { padding-top: 0.05rem; padding-bottom: 0.05rem; }
    .me-1.5 { margin-right: 0.35rem; }
    
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .tracking-wider { letter-spacing: 0.05em; }
    .max-width-text { max-width: 450px; }
    .min-width-badge { min-width: 105px; }
</style>
@endpush