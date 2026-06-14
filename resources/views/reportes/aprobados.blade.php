@extends('layouts.app')

@section('title', 'Aprobados y Reprobados')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Reporte de Aprobados y Reprobados</h4>
                    <p class="mb-0 text-white-50 small mt-1">Estadísticas generales de rendimiento y listados consolidados del proceso de admisión</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-success">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Total Aprobados</span>
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
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Total Reprobados</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $totalReprobados }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-user-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Tasa de Aprobación</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ number_format($tasaAprobacion, 1) }}%</h3>
                            </div>
                            <div class="indicator-circle-bg bg-info bg-opacity-10 text-info-custom">
                                <i class="fas fa-percentage"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-2xs rounded-3 mb-4 bg-white">
                <div class="card-header border-0 bg-transparent pt-3 pb-0">
                    <h5 class="fw-bold text-success mb-0 font-size-md d-flex align-items-center">
                        <i class="fas fa-check-circle me-2 opacity-75"></i> Postulantes Aprobados
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive rounded-3 border bg-white">
                        <table class="table table-hover align-middle mb-0 datatable">
                            <thead class="custom-table-header text-white">
                                <tr>
                                    <th class="py-2.5 px-3" style="width: 140px;">CI</th>
                                    <th class="py-2.5">Nombres</th>
                                    <th class="py-2.5">Apellidos</th>
                                    <th class="py-2.5">Carrera Asignada</th>
                                    <th class="text-center py-2.5" style="width: 130px;">Promedio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aprobados as $p)
                                <tr class="row-hover-effect">
                                    <td class="px-3 fw-bold text-dark font-monospace font-size-sm">{{ $p->ci }}</td>
                                    <td class="fw-medium font-size-sm">{{ $p->nombres }}</td>
                                    <td class="fw-medium font-size-sm">{{ $p->apellidos }}</td>
                                    <td class="font-size-sm">
                                        @if($p->carreraAsignada)
                                            <strong class="text-primary-custom">{{ $p->carreraAsignada->nombre }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-success border-opacity-10">
                                            {{ number_format($p->promedio_final ?? 0, 2) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 bg-light bg-opacity-50">
                                        <span class="text-muted small"><i class="fas fa-info-circle me-1"></i> No se registran postulantes aprobados en este ciclo.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-2xs rounded-3 bg-white">
                <div class="card-header border-0 bg-transparent pt-3 pb-0">
                    <h5 class="fw-bold text-danger mb-0 font-size-md d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2 opacity-75"></i> Postulantes Reprobados
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive rounded-3 border bg-white">
                        <table class="table table-hover align-middle mb-0 datatable">
                            <thead class="custom-table-header text-white">
                                <tr>
                                    <th class="py-2.5 px-3" style="width: 140px;">CI</th>
                                    <th class="py-2.5">Nombres</th>
                                    <th class="py-2.5">Apellidos</th>
                                    <th class="py-2.5">Carrera Asignada</th>
                                    <th class="text-center py-2.5" style="width: 130px;">Promedio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reprobados as $p)
                                <tr class="row-hover-effect">
                                    <td class="px-3 fw-bold text-dark font-monospace font-size-sm">{{ $p->ci }}</td>
                                    <td class="fw-medium font-size-sm">{{ $p->nombres }}</td>
                                    <td class="fw-medium font-size-sm">{{ $p->apellidos }}</td>
                                    <td class="font-size-sm">
                                        @if($p->carreraAsignada)
                                            <strong class="text-primary-custom">{{ $p->carreraAsignada->nombre }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-danger border-opacity-10">
                                            {{ number_format($p->promedio_final ?? 0, 2) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 bg-light bg-opacity-50">
                                        <span class="text-muted small"><i class="fas fa-info-circle me-1"></i> No se registran postulantes reprobados en este ciclo.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras de encabezado y tablas */
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

    /* Indicadores laterales de tarjetas */
    .card-indicator-border-success { border-left: 4px solid #28a745 !important; }
    .card-indicator-border-danger { border-left: 4px solid #dc3545 !important; }
    .card-indicator-border-info { border-left: 4px solid #17a2b8 !important; }

    .indicator-circle-bg {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.15rem;
    }

    /* Esquemas de color suavizados */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }

    /* Clases utilitarias fijas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endpush