@extends('layouts.app')

@section('title', 'Exportar Reportes')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-download fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Exportar Reportes</h4>
                    <p class="mb-0 text-white-50 small mt-1">Descarga y extracción de listados del CUP en formatos estructurados</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-4 d-flex align-items-center p-3">
                <i class="fas fa-info-circle fa-lg me-2.5"></i>
                <span class="small fw-medium">Seleccione el formato oficial en el que desea exportar el reporte consolidado de postulantes.</span>
            </div>
            
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 text-center transition-all group-item-card bg-white p-4">
                        <div class="card-body d-flex flex-column align-items-center justify-content-between p-2">
                            <div class="mb-3">
                                <div class="icon-circle-bg bg-success bg-opacity-10 text-success mb-3 mx-auto">
                                    <i class="fas fa-file-excel fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2 font-size-md">Exportar a Excel</h5>
                                <p class="text-muted small mb-0 px-2">Genera y descarga la lista completa de postulantes en formato estructurado CSV compatible con Microsoft Excel.</p>
                            </div>
                            <a href="{{ route('export.excel') }}" class="btn btn-success font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto mt-2">
                                <i class="fas fa-download me-1"></i> Descargar Excel
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 text-center transition-all group-item-card bg-white p-4">
                        <div class="card-body d-flex flex-column align-items-center justify-content-between p-2">
                            <div class="mb-3">
                                <div class="icon-circle-bg bg-danger bg-opacity-10 text-danger mb-3 mx-auto">
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2 font-size-md">Exportar a PDF</h5>
                                <p class="text-muted small mb-0 px-2">Genera un documento formal optimizado para impresión con el listado completo de todos los postulantes.</p>
                            </div>
                            <a href="{{ route('export.pdf') }}" class="btn btn-danger font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto mt-2">
                                <i class="fas fa-download me-1"></i> Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-top">
                <div class="alert alert-warning border-0 rounded-4 shadow-2xs bg-warning bg-opacity-10 p-3 mb-0">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line text-warning fa-lg me-2.5"></i>
                            <div>
                                <strong class="text-dark font-size-sm d-block">¿Necesitas estadísticas detalladas?</strong>
                                <span class="text-muted small">Visualiza gráficos analíticos de rendimiento y distribución de cupos.</span>
                            </div>
                        </div>
                        <a href="{{ route('reportes.estadisticas') }}" class="btn btn-sm btn-action-info text-white fw-bold px-3 py-2 rounded-3 shadow-2xs hover-up w-100 w-sm-auto text-center">
                            <i class="fas fa-chart-pie me-1"></i> Ver Estadísticas por Materia
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estructuras y dimensiones */
    .metric-icon-box {
        width: 44px;
        height: 44px;
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

    /* Contenedor circular para íconos de formato */
    .icon-circle-bg {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Colores e intensidades corporativas */
    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    
    .btn-action-info {
        background-color: #17a2b8;
    }
    .btn-action-info:hover {
        background-color: #117a8b;
    }

    /* Utilidades responsivas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }

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