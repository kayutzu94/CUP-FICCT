@extends('layouts.app')

@section('title', 'Reporte de Asignación por Mérito')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-chalkboard-user fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Asignación de Carreras por Mérito</h4>
                    <p class="mb-0 text-white-50 small mt-1">Postulantes aprobados asignados sistemáticamente según su orden de preferencia y promedio final</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-success">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Total Aprobados</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $totalAprobados }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-success bg-opacity-10 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Primera Opción</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $primeraOpcion }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-info bg-opacity-10 text-info-custom">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-warning">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Segunda Opción</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $segundaOpcion }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-warning bg-opacity-10 text-warning-custom">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white h-100 p-3 card-indicator-border-secondary">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider">Lista de Espera</span>
                                <h3 class="mb-0 fw-bold text-dark mt-1 font-monospace">{{ $listaEspera }}</h3>
                            </div>
                            <div class="indicator-circle-bg bg-secondary bg-opacity-10 text-secondary">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-3 mb-4 bg-white border">
                <div class="card-body p-3.5">
                    <form method="GET" action="{{ route('reportes.lista') }}" id="filtrosForm">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-xl-3">
                                <label class="form-label text-dark fw-medium small mb-1.5">
                                    <i class="fas fa-filter text-muted me-1"></i> Filtrar por Asignación
                                </label>
                                <select name="tipo_asignacion" class="form-select border font-size-sm" onchange="this.form.submit()">
                                    <option value="">📋 Todos los asignados</option>
                                    <option value="primera" {{ request('tipo_asignacion') == 'primera' ? 'selected' : '' }}>🏆 Primera Opción</option>
                                    <option value="segunda" {{ request('tipo_asignacion') == 'segunda' ? 'selected' : '' }}>🥈 Segunda Opción</option>
                                    <option value="lista_espera" {{ request('tipo_asignacion') == 'lista_espera' ? 'selected' : '' }}>⏳ Lista de Espera</option>
                                </select>
                            </div>
                                            
                            <div class="col-12 col-md-6 col-xl-3">
                                <label class="form-label text-dark fw-medium small mb-1.5">
                                    <i class="fas fa-graduation-cap text-muted me-1"></i> Filtrar por Carrera
                                </label>
                                <select name="carrera_id" class="form-select border font-size-sm" onchange="this.form.submit()">
                                    <option value="">🎯 Todas las carreras</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                            {{ $carrera->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                            
                            <div class="col-12 col-md-8 col-xl-4">
                                <label class="form-label text-dark fw-medium small mb-1.5">
                                    <i class="fas fa-search text-muted me-1"></i> Buscar por nombre / CI / Email
                                </label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control border font-size-sm" value="{{ request('search') }}" placeholder="Escriba parámetro..." id="searchInput">
                                    <button type="submit" class="btn btn-action font-size-sm px-3 fw-bold">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request('search') || request('tipo_asignacion') || request('carrera_id') || request('promedio_min') || request('promedio_max') || request('sexo') || request('ciudad'))
                                        <a href="{{ route('reportes.lista') }}" class="btn btn-secondary border-0 font-size-sm d-flex align-items-center">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                                            
                            <div class="col-12 col-md-4 col-xl-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-secondary font-size-sm w-100 fw-medium d-flex align-items-center justify-content-center gap-1 py-2 rounded-3" onclick="toggleAllFilters()">
                                    <i class="fas fa-sliders-h"></i> Filtros Avanzados
                                </button>
                            </div>
                        </div>
                                    
                        <div id="filtrosAvanzados" style="display: none;" class="row g-3 mt-2 pt-3 border-top fade-in-fast">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label text-dark fw-medium small mb-1.5"><i class="fas fa-chart-line text-muted me-1"></i> Promedio mínimo</label>
                                <input type="number" name="promedio_min" class="form-control border font-size-sm" step="0.01" value="{{ request('promedio_min') }}" placeholder="Ej: 70">
                            </div>
                                            
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label text-dark fw-medium small mb-1.5"><i class="fas fa-chart-line text-muted me-1"></i> Promedio máximo</label>
                                <input type="number" name="promedio_max" class="form-control border font-size-sm" step="0.01" value="{{ request('promedio_max') }}" placeholder="Ej: 100">
                            </div>
                                            
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label text-dark fw-medium small mb-1.5"><i class="fas fa-venus-mars text-muted me-1"></i> Sexo</label>
                                <select name="sexo" class="form-select border font-size-sm" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ request('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                                            
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label text-dark fw-medium small mb-1.5"><i class="fas fa-city text-muted me-1"></i> Ciudad</label>
                                <input type="text" name="ciudad" class="form-control border font-size-sm" value="{{ request('ciudad') }}" placeholder="Ciudad de origen">
                            </div>
                            
                            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="submit" class="btn btn-action-info text-white font-size-sm px-4 py-2 rounded-3 fw-bold shadow-2xs hover-up">
                                    <i class="fas fa-sync-alt me-1"></i> Aplicar Avanzados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0" id="tablaAsignacion">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th style="width: 60px;" class="text-center py-3">#</th>
                            <th class="py-3">CI</th>
                            <th class="py-3">Nombre Completo</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Primera Opción</th>
                            <th class="py-3">Segunda Opción</th>
                            <th class="py-3">Carrera Asignada</th>
                            <th class="py-3">Tipo Asignación</th>
                            <th class="text-center py-3" style="width: 140px;">Promedio Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($postulantes as $postulante)
                        @php
                            $esPrimera = ($postulante->carrera_asignada_id == $postulante->primera_carrera_id);
                            $esSegunda = ($postulante->carrera_asignada_id == $postulante->segunda_carrera_id);
                            $enListaEspera = is_null($postulante->carrera_asignada_id);
                        @endphp
                        <tr class="row-hover-effect">
                            <td class="text-center fw-bold text-muted font-size-sm">{{ $loop->iteration + ($postulantes->currentPage() - 1) * $postulantes->perPage() }}</td>
                            <td class="fw-bold text-dark font-monospace font-size-sm">{{ $postulante->ci }}</td>
                            <td class="fw-medium font-size-sm">{{ $postulante->nombres }} {{ $postulante->apellidos }}</td>
                            <td class="text-secondary font-size-sm">{{ $postulante->email }}</td>
                            <td>
                                @if($postulante->primeraCarrera)
                                    <span class="badge bg-light text-dark border font-size-xs px-2 py-1.5 d-inline-block text-truncate" style="max-width: 150px;">{{ $postulante->primeraCarrera->nombre }}</span>
                                @else
                                    <span class="text-muted font-size-xs">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($postulante->segundaCarrera)
                                    <span class="badge bg-light text-dark border font-size-xs px-2 py-1.5 d-inline-block text-truncate" style="max-width: 150px;">{{ $postulante->segundaCarrera->nombre }}</span>
                                @else
                                    <span class="text-muted font-size-xs">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($postulante->carreraAsignada)
                                    <strong class="text-primary-custom font-size-sm">{{ $postulante->carreraAsignada->nombre }}</strong>
                                @else
                                    <span class="badge bg-danger-soft text-danger font-size-xs px-2 py-1.5 border border-danger border-opacity-10"><i class="fas fa-ban me-1"></i> No asignado</span>
                                @endif
                            </td>
                            <td>
                                @if($enListaEspera)
                                    <span class="badge bg-secondary-soft text-secondary px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-secondary border-opacity-10">
                                        <i class="fas fa-hourglass-half me-1"></i> Espera
                                    </span>
                                @elseif($esPrimera)
                                    <span class="badge bg-success-soft text-success px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-success border-opacity-10">
                                        <i class="fas fa-trophy me-1 text-warning"></i> 1ra Opción
                                    </span>
                                @elseif($esSegunda)
                                    <span class="badge bg-warning-soft text-warning-custom px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-warning border-opacity-10">
                                        <i class="fas fa-medal me-1"></i> 2da Opción
                                    </span>
                                @else
                                    <span class="badge bg-primary-soft text-primary-custom px-2 py-1.5 rounded-pill font-size-xs fw-bold border border-primary border-opacity-10">
                                        Especial
                                    </span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-success font-monospace font-size-sm">
                                {{ number_format($postulante->promedio_final ?? 0, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 bg-white bg-opacity-50">
                                <div class="py-3">
                                    <i class="fas fa-user-slash text-muted fa-3x mb-3 opacity-40"></i>
                                    <h5 class="text-muted fw-normal">No se encontraron postulantes aprobados</h5>
                                    <p class="text-muted small mb-0">Modifique los criterios o parámetros de búsqueda en la sección de filtrado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($postulantes->hasPages())
                <div class="mt-4 d-flex justify-content-center custom-pagination-wrapper">
                    {{ $postulantes->appends(request()->query())->links() }}
                </div>
            @endif
            
            <div class="mt-4 pt-3 border-top d-flex flex-wrap gap-2 justify-content-start">
                <button onclick="exportToExcel()" class="btn btn-success font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto">
                    <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                </button>
                <button onclick="printTable()" class="btn btn-danger font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto">
                    <i class="fas fa-print me-1"></i> Imprimir / PDF
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mantener desplegado el contenedor de filtros avanzados si hay parámetros activos en él
    const promedioMin = "{{ request('promedio_min') }}";
    const promedioMax = "{{ request('promedio_max') }}";
    const sexo = "{{ request('sexo') }}";
    const ciudad = "{{ request('ciudad') }}";
    
    if (promedioMin || promedioMax || sexo || ciudad) {
        const filtros = document.getElementById('filtrosAvanzados');
        if (filtros) filtros.style.display = 'flex';
    }

    // Enter en el input de texto activa submit directo sin perder consistencia
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }
        
    mostrarFiltrosActivos();
});

function toggleAllFilters() {
    const filtros = document.getElementById('filtrosAvanzados');
    if (filtros.style.display === 'none') {
        filtros.style.display = 'flex';
    } else {
        filtros.style.display = 'none';
    }
}

function mostrarFiltrosActivos() {
    const filtrosActivos = [];
    const tipo = "{{ request('tipo_asignacion') }}";
    const carrera = "{{ request('carrera_id') }}";
    const search = "{{ request('search') }}";
    const promedioMin = "{{ request('promedio_min') }}";
    const promedioMax = "{{ request('promedio_max') }}";
    const sexo = "{{ request('sexo') }}";
    const ciudad = "{{ request('ciudad') }}";
        
    if (tipo) filtrosActivos.push(`Asignación: ${tipo}`);
    if (carrera) filtrosActivos.push('Carrera específica');
    if (search) filtrosActivos.push(`Búsqueda: ${search}`);
    if (promedioMin) filtrosActivos.push(`Promedio ≥ ${promedioMin}`);
    if (promedioMax) filtrosActivos.push(`Promedio ≤ ${promedioMax}`);
    if (sexo) filtrosActivos.push(`Sexo: ${sexo === 'M' ? 'Masculino' : 'Femenino'}`);
    if (ciudad) filtrosActivos.push(`Ciudad: ${ciudad}`);
        
    if (filtrosActivos.length > 0) {
        const alertHtml = `
            <div class="alert alert-info alert-dismissible border-0 shadow-2xs rounded-3 bg-primary-soft text-primary-custom mt-3 d-flex align-items-center p-3 mb-0" role="alert">
                <i class="fas fa-filter fa-lg me-2.5"></i>
                <div class="small fw-medium flex-fill">
                    <strong>Filtros activos:</strong> ${filtrosActivos.join(', ')}
                </div>
                <a href="{{ route('reportes.lista') }}" class="btn btn-sm btn-outline-secondary font-size-xs px-2.5 py-1 rounded-3 ms-2 text-dark bg-white border">Resetear Filtros</a>
                <button type="button" class="btn-close shadow-none p-3" data-bs-dismiss="alert" style="top:50%; transform:translateY(-50%);"></button>
            </div>
        `;
        const existingAlert = document.querySelector('.alert-info');
        if (!existingAlert) {
            const formContainer = document.querySelector('#filtrosForm');
            formContainer.parentElement.insertAdjacentHTML('beforeend', alertHtml);
        }
    }
}

function exportToExcel() {
    let table = document.getElementById('tablaAsignacion');
    let html = table.outerHTML;
        
    let title = '<h2>Reporte de Asignación por Mérito</h2>';
    let date = '<p>Fecha: ' + new Date().toLocaleString() + '</p>';
        
    let fullHtml = `
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Reporte Asignación</title>
                <style>
                    th { background-color: #0a2b5e; color: #ffffff; }
                    td, th { border: 1px solid #ddd; padding: 8px; font-family: sans-serif; }
                </style>
            </head>
            <body>
                ${title}
                ${date}
                ${html}
            </body>
        </html>
    `;
        
    let url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(fullHtml);
    let link = document.createElement('a');
    link.href = url;
    link.download = 'reporte_asignacion_merito_' + new Date().toISOString().slice(0,10) + '.xls';
        
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function printTable() {
    let table = document.getElementById('tablaAsignacion');
    let windowRef = window.open('', '_blank');
    windowRef.document.write(`
        <html>
            <head>
                <title>Reporte de Asignación</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 30px; color: #333; }
                    th { background-color: #0a2b5e; color: white; padding: 10px; font-size: 13px; }
                    td, th { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                    h1 { color: #0a2b5e; margin-bottom: 5px; }
                    p { margin-top: 0; color: #666; font-size: 13px; }
                </style>
            </head>
            <body>
                <h1>Reporte de Asignación por Mérito</h1>
                <p>Fecha de emisión oficial: ${new Date().toLocaleString()}</p>
                ${table.outerHTML}
            </body>
        </html>
    `);
    windowRef.document.close();
    windowRef.print();
}
</script>
@endpush

@push('styles')
<style>
    /* Estructuras generales y tablas */
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

    /* Bordes e indicadores de tarjetas de métricas */
    .card-indicator-border-success { border-left: 4px solid #28a745 !important; }
    .card-indicator-border-info { border-left: 4px solid #17a2b8 !important; }
    .card-indicator-border-warning { border-left: 4px solid #ffc107 !important; }
    .card-indicator-border-secondary { border-left: 4px solid #6c757d !important; }

    .indicator-circle-bg {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.15rem;
    }

    /* Badges con contrastes suaves */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-info-soft { background-color: rgba(23, 162, 184, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.14); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.12); }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }
    .text-warning-custom { color: #b78a02 !important; }

    /* Estilos de botones */
    .btn-action {
        background-color: #0a2b5e;
        color: white;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }
    .btn-action-info {
        background-color: #17a2b8;
    }
    .btn-action-info:hover {
        background-color: #117a8b;
    }

    /* Clases utilitarias fijas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .mb-1.5 { margin-bottom: 0.35rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .tracking-wider { letter-spacing: 0.05em; }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }

    .fade-in-fast {
        animation: fadeInFast 0.25s ease-out;
    }
    @keyframes fadeInFast {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .custom-pagination-wrapper nav {
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    /* Control CSS nativo para modo impresión */
    @media print {
        .btn, .alert, form, .custom-pagination-wrapper, .metric-icon-box {
            display: none !important;
        }
        .card, .card-body {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
        body {
            padding: 0;
            margin: 0;
            background: white;
        }
    }
</style>
@endpush
@endsection