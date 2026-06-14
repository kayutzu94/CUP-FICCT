@extends('layouts.app')

@section('title', 'Importar Datos')

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

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-upload fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Importación de Datos</h4>
                    <p class="mb-0 text-white-50 small mt-1">Carga masiva de registros para el sistema académico CUP</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-40">
            <div class="row g-3">
                
                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden group-item-card transition-all bg-white">
                        <div class="card-header border-0 py-3 px-3 text-white d-flex align-items-center" style="background-color: #28a745;">
                            <i class="fas fa-users me-2 opacity-75"></i>
                            <h5 class="mb-0 fw-bold font-size-md">Importar Postulantes</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-secondary small mb-3">Sube la lista de postulantes registrados desde una planilla externa de forma directa.</p>
                                
                                <div class="bg-light p-3 rounded-3 border mb-4">
                                    <div class="d-flex align-items-center mb-1.5">
                                        <i class="fas fa-table text-success me-2 font-size-sm"></i>
                                        <span class="small fw-bold text-dark">Formato requerido:</span>
                                    </div>
                                    <code class="text-success font-size-xs fw-semibold font-monospace d-block break-word">
                                        CI, nombres, apellidos, email, primera_carrera, segunda_carrera
                                    </code>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('importacion.import') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border text-muted"><i class="fas fa-file-excel"></i></span>
                                        <input type="file" name="archivo" class="form-control border font-size-sm" accept=".csv,.xlsx,.xls" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success font-size-sm px-4 py-2 w-100 fw-bold shadow-sm hover-up">
                                    <i class="fas fa-cloud-upload-alt me-1"></i> Procesar Postulantes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden group-item-card transition-all bg-white">
                        <div class="card-header border-0 py-3 px-3 text-white d-flex align-items-center" style="background-color: #17a2b8;">
                            <i class="fas fa-user-plus me-2 opacity-75"></i>
                            <h5 class="mb-0 fw-bold font-size-md">Importar Usuarios</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-secondary small mb-3">Gestiona la carga masiva de nuevos perfiles de docentes o coordinadores de la facultad.</p>
                                
                                <div class="bg-light p-3 rounded-3 border mb-4">
                                    <div class="d-flex align-items-center mb-1.5">
                                        <i class="fas fa-id-card text-info-custom me-2 font-size-sm"></i>
                                        <span class="small fw-bold text-dark">Formato requerido:</span>
                                    </div>
                                    <code class="text-info-custom font-size-xs fw-semibold font-monospace d-block break-word">
                                        CI, nombres, apellidos, email, profesion, especialidad
                                    </code>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <a href="{{ route('importacion.usuarios') }}" class="btn btn-action-info font-size-sm px-4 py-2 w-100 fw-bold shadow-sm hover-up text-white text-center d-block">
                                    Ir a Importar Usuarios <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mt-4 mb-0 d-flex align-items-center p-3">
                <i class="fas fa-info-circle fa-lg me-2.5"></i>
                <span class="small fw-medium">📌 <strong>Nota institucional:</strong> Si no cuenta con el archivo base, recuerde que puede descargar la plantilla de ejemplo desde la sección de "Importar Usuarios" para conocer el formato exacto.</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estructuras y contenedores fijos */
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

    /* Colores y estilos de botones */
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .btn-action-info {
        background-color: #17a2b8;
    }
    .btn-action-info:hover {
        background-color: #117a8b;
    }

    /* Clases utilitarias adaptables */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .mb-1.5 { margin-bottom: 0.35rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .break-word { word-break: break-all; }

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