@extends('layouts.app')

@section('title', 'Cantidad de Grupos Habilitados')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                        <i class="fas fa-calculator fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white">Cantidad de Grupos Habilitados</h4>
                        <p class="mb-0 text-white-50 small mt-1">Análisis de capacidad operativa, balance de aforo matemático y proyección de infraestructura</p>
                    </div>
                </div>
                <div>
                    <button onclick="window.print()" class="btn btn-light btn-sm text-primary-custom font-size-sm fw-bold px-3 py-1.8 rounded-3 shadow-2xs border-0 hover-up">
                        <i class="fas fa-print me-1"></i> Imprimir Reporte
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider">Total Inscritos</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ number_format($totalInscritos) }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-info bg-opacity-10 text-info-custom">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-warning">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider">Capacidad Base</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">70</h3>
                                <span class="text-muted font-size-3xs d-block mt-0.5">Alumnos por aula</span>
                            </div>
                            <div class="indicator-circle-bg bg-warning bg-opacity-10 text-warning-custom">
                                <i class="fas fa-th-large"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-success">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider">Grupos Requeridos</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $gruposNecesarios }}</h3>
                                <span class="text-muted font-size-3xs d-block mt-0.5 font-monospace">CEIL(N/70)</span>
                            </div>
                            <div class="indicator-circle-bg bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-primary">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider">Grupos Actuales</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $totalGrupos }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-primary bg-opacity-10 text-primary-custom">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-2xs rounded-3 mb-4 bg-white p-3.5">
                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-chart-pie text-secondary me-1"></i> Balance de Ocupación General de Infraestructura
                </span>
                
                @php
                    $pctUtilizado = $capacidadTotal > 0 ? ($capacidadUtilizada / $capacidadTotal) * 100 : 0;
                    $pctLibre = $capacidadTotal > 0 ? ($capacidadLibre / $capacidadTotal) * 100 : 0;
                @endphp
                
                <div class="progress rounded-pill shadow-3xs overflow-hidden mb-2.5" style="height: 24px;">
                    @if($pctUtilizado > 0)
                        <div class="progress-bar bg-success rounded-start font-size-2xs fw-bold text-white text-shadow-sm" 
                             role="progressbar" 
                             style="width: {{ $pctUtilizado }}%">
                             Ocupado: {{ $capacidadUtilizada }} Alumnos
                        </div>
                    @endif
                    @if($pctLibre > 0)
                        <div class="progress-bar bg-secondary bg-opacity-20 text-secondary font-size-2xs fw-bold border-start border-white" 
                             role="progressbar" 
                             style="width: {{ $pctLibre }}%">
                             Libre: {{ $capacidadLibre }} Vacantes
                        </div>
                    @endif
                </div>
                
                <div class="text-center font-size-xs text-secondary mt-2 border-top pt-2">
                    <i class="fas fa-warehouse opacity-70 me-1"></i> Capacidad Máxima del Sistema: 
                    <strong class="text-dark font-monospace">{{ $capacidadTotal }}</strong> Estudiantes 
                    <span class="text-muted">({{ $totalGrupos }} grupos parametrizados a x70)</span>
                </div>
            </div>
            
            <div class="card border-0 shadow-2xs rounded-3 mb-4 bg-white">
                <div class="card-header border-0 bg-transparent pt-3 pb-2">
                    <h5 class="fw-bold text-dark mb-0 font-size-md d-flex align-items-center">
                        <i class="fas fa-th-list me-2 text-primary-custom opacity-75"></i> Distribución Estudiantil Efectiva por Grupo
                    </h5>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="table-responsive rounded-3 border bg-white">
                        <table class="table table-hover align-middle mb-0 datatable">
                            <thead class="custom-table-header text-white">
                                <tr>
                                    <th class="py-2.5 px-3">Grupo / Aula</th>
                                    <th class="py-2.5" style="width: 140px;">Código Interno</th>
                                    <th class="text-center py-2.5" style="width: 150px;">Estudiantes Actuales</th>
                                    <th class="text-center py-2.5" style="width: 150px;">Capacidad Máxima</th>
                                    <th class="py-2.5" style="min-width: 170px; width: 220px;">Nivel de Ocupación</th>
                                    <th class="text-center py-2.5" style="width: 130px;">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupos as $grupo)
                                <tr class="row-hover-effect">
                                    <td class="px-3">
                                        <strong class="text-dark font-size-sm">{{ $grupo->nombre }}</strong>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-secondary border font-size-2xs font-monospace px-2 py-0.5">{{ $grupo->codigo }}</span>
                                    </td>
                                    
                                    <td class="text-center fw-bold text-primary-custom font-monospace font-size-sm">
                                        {{ $grupo->postulantes_count }}
                                    </td>
                                    
                                    <td class="text-center fw-semibold text-secondary font-monospace font-size-sm">
                                        {{ $grupo->capacidad_maxima }}
                                    </td>
                                    
                                    <td>
                                        @php
                                            $porcentaje = $grupo->capacidad_maxima > 0 ? ($grupo->postulantes_count / $grupo->capacidad_maxima) * 100 : 0;
                                            $barraColor = $porcentaje >= 90 ? 'bg-danger' : ($porcentaje >= 70 ? 'bg-warning' : 'bg-success');
                                            $textColor = ($porcentaje >= 70 && $barraColor == 'bg-warning') ? 'text-dark' : 'text-white';
                                        @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress rounded-pill flex-fill shadow-3xs" style="height: 14px;">
                                                <div class="progress-bar {{ $barraColor }} {{ $textColor }} rounded-pill font-size-3xs fw-bold" 
                                                     role="progressbar" 
                                                     style="width: {{ $porcentaje }}%">
                                                     @if($porcentaje > 20) {{ number_format($porcentaje, 1) }}% @endif
                                                </div>
                                            </div>
                                            @if($porcentaje <= 20)
                                                <span class="font-size-3xs font-monospace fw-bold text-muted">{{ number_format($porcentaje, 1) }}%</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        @if($grupo->postulantes_count >= $grupo->capacidad_maxima)
                                            <span class="badge bg-danger-soft text-danger px-2.5 py-1.2 rounded-pill font-size-xs fw-bold border border-danger border-opacity-10 d-block">
                                                Completo
                                            </span>
                                        @elseif($grupo->postulantes_count >= $grupo->capacidad_maxima * 0.7)
                                            <span class="badge bg-warning-soft text-warning-custom px-2.5 py-1.2 rounded-pill font-size-xs fw-bold border border-warning border-opacity-10 d-block">
                                                Casi Lleno
                                            </span>
                                        @else
                                            <span class="badge bg-success-soft text-success px-2.5 py-1.2 rounded-pill font-size-xs fw-bold border border-success border-opacity-10 d-block">
                                                Disponible
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
            
            <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-0 p-3">
                <div class="d-flex align-items-start">
                    <i class="fas fa-drafting-compass fa-lg me-2.5 mt-0.5"></i>
                    <div class="small">
                        <strong>📐 Sustento y algoritmo métrico aplicado:</strong>
                        <span class="text-secondary d-block mt-0.5">
                            La cantidad teórica óptima de ambientes se procesa mediante redondeo por exceso: <code>Cantidad de Grupos = CEIL(Total Inscritos / 70)</code>
                        </span>
                        <div class="bg-white bg-opacity-60 px-2 py-1 rounded border font-size-2xs font-monospace text-dark d-inline-block mt-1.5">
                            Muestra analítica: {{ $totalInscritos }} inscritos ÷ 70 = {{ number_format($totalInscritos / 70, 4) }} → Aplicando función techo (CEIL) = {{ $gruposNecesarios }} grupos requeridos.
                        </div>
                    </div>
                </div>
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

    /* Indicadores de borde de tarjeta lateral */
    .card-indicator-border-info { border-left: 4px solid #17a2b8 !important; }
    .card-indicator-border-warning { border-left: 4px solid #ffc107 !important; }
    .card-indicator-border-success { border-left: 4px solid #28a745 !important; }
    .card-indicator-border-primary { border-left: 4px solid #0a2b5e !important; }

    .indicator-circle-bg {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.1rem;
    }

    /* Esquemas suaves para Badges */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.14); }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }
    .text-warning-custom { color: #b78a02 !important; }

    /* Estructuras utilitarias de consistencia */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .py-1.2 { padding-top: 0.3rem; padding-bottom: 0.3rem; }
    .py-1.8 { padding-top: 0.45rem; padding-bottom: 0.45rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .mb-2.5 { margin-bottom: 0.65rem; }
    .mt-1.5 { margin-top: 0.35rem; }
    .p-3.5 { padding: 1.1rem !important; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .font-size-3xs { font-size: 0.65rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .tracking-wider { letter-spacing: 0.05em; }
    .text-shadow-sm { text-shadow: 0 1px 1px rgba(0,0,0,0.2); }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }

    /* Reglas específicas para impresión limpia */
    @media print {
        .card-header button, .alert, .text-end { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .table-responsive { overflow: visible !important; }
        body { background: white !important; }
    }
</style>
@endpush