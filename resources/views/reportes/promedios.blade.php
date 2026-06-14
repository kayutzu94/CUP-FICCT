@extends('layouts.app')

@section('title', 'Promedios Generales')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Promedios Generales del Sistema</h4>
                    <p class="mb-0 text-white-50 small mt-1">Historial centralizado de calificaciones finales, ponderaciones y estados académicos por postulante</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Promedio General</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ number_format($promedioGeneral, 2) }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-info bg-opacity-10 text-info-custom">
                                <i class="fas fa-calculator"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-success">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Aprobados</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $totalAprobados }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-success bg-opacity-10 text-success">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-danger">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Reprobados</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $totalReprobados }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-user-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3" style="width: 140px;">CI</th>
                            <th class="py-3">Nombre Completo del Postulante</th>
                            <th class="py-3">Carrera Asignada</th>
                            <th class="text-center py-3" style="width: 130px;">Promedio</th>
                            <th class="text-center py-3" style="width: 140px;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($postulantes as $p)
                        <tr class="row-hover-effect">
                            <td class="px-3 fw-bold text-dark font-monospace font-size-sm">
                                {{ $p->ci }}
                            </td>
                            
                            <td class="fw-medium font-size-sm text-dark">
                                {{ $p->nombres }} {{ $p->apellidos }}
                            </td>
                            
                            <td class="font-size-sm">
                                @if($p->carreraAsignada)
                                    <strong class="text-primary-custom">{{ $p->carreraAsignada->nombre }}</strong>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                @php
                                    $esNotaAprobatoria = ($p->promedio_final ?? 0) >= 51; // Adaptado según umbral estándar institucional
                                    $badgeClaseMateria = $esNotaAprobatoria ? 'bg-success-soft text-success border border-success' : 'bg-danger-soft text-danger border border-danger';
                                @endphp
                                <span class="badge {{ $badgeClaseMateria }} border-opacity-10 px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace">
                                    {{ number_format($p->promedio_final ?? 0, 2) }}
                                </span>
                            </td>
                            
                            <td class="text-center">
                                @if($p->estado_academico == 'aprobado')
                                    <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-success border-opacity-10 w-100 d-block max-width-badge mx-auto">
                                        <i class="fas fa-check me-1"></i> APROBADO
                                    </span>
                                @else
                                    <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-danger border-opacity-10 w-100 d-block max-width-badge mx-auto">
                                        <i class="fas fa-times me-1"></i> REPROBADO
                                    </span>
                                @endif
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
    /* Estructuras fijas e institucionales */
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

    /* Indicadores de borde e íconos flotantes */
    .card-indicator-border-info { border-left: 4px solid #17a2b8 !important; }
    .card-indicator-border-success { border-left: 4px solid #28a745 !important; }
    .card-indicator-border-danger { border-left: 4px solid #dc3545 !important; }

    .indicator-circle-bg {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.15rem;
    }

    /* Esquemas e intensidades cromáticas suaves */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }

    /* Clases de ajuste utilitarias responsivas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .tracking-wider { letter-spacing: 0.05em; }
    .max-width-badge { max-width: 115px; }
</style>
@endpush