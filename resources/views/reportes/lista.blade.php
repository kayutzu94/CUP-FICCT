@extends('layouts.app')

@section('title', 'Reporte de Asignación por Mérito')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h3 class="mb-0">
                <i class="fas fa-chalkboard-user"></i> Asignación de Carreras por Mérito
            </h3>
            <p class="mb-0 mt-2">
                <small>Postulantes aprobados asignados según su orden de preferencia</small>
            </p>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3 mb-2">
                    <div class="card bg-success text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-check-circle"></i> Total Aprobados
                            </h5>
                            <h2 class="mb-0 fw-bold">{{ $totalAprobados }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card bg-info text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-star"></i> Primera Opción
                            </h5>
                            <h2 class="mb-0 fw-bold">{{ $primeraOpcion }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card bg-warning text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-thumbs-up"></i> Segunda Opción
                            </h5>
                            <h2 class="mb-0 fw-bold">{{ $segundaOpcion }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="card bg-secondary text-white shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-clock"></i> Lista de Espera
                            </h5>
                            <h2 class="mb-0 fw-bold">{{ $listaEspera }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4 bg-light border">
                <div class="card-body">
                    <form method="GET" action="{{ route('reportes.lista') }}" id="filtrosForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-filter"></i> Filtrar por Asignación
                                </label>
                                <select name="tipo_asignacion" class="form-select" onchange="this.form.submit()">
                                    <option value="">📋 Todos los asignados</option>
                                    <option value="primera" {{ request('tipo_asignacion') == 'primera' ? 'selected' : '' }}>
                                        🏆 Primera Opción
                                    </option>
                                    <option value="segunda" {{ request('tipo_asignacion') == 'segunda' ? 'selected' : '' }}>
                                        🥈 Segunda Opción
                                    </option>
                                    <option value="lista_espera" {{ request('tipo_asignacion') == 'lista_espera' ? 'selected' : '' }}>
                                        ⏳ Lista de Espera
                                    </option>
                                </select>
                            </div>
                                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-graduation-cap"></i> Filtrar por Carrera
                                </label>
                                <select name="carrera_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">🎯 Todas las carreras</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                            {{ $carrera->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                            
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-search"></i> Buscar por nombre/CI/Email
                                </label>
                                <div class="input-group">
                                    <input type="text" 
                                           name="search" 
                                           class="form-control" 
                                           value="{{ request('search') }}" 
                                           placeholder="Nombre, CI o email..." 
                                           id="searchInput">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('search') || request('tipo_asignacion') || request('carrera_id') || request('promedio_min') || request('promedio_max') || request('sexo') || request('ciudad'))
                                        <a href="{{ route('reportes.lista') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Limpiar
                                        </a>
                                    @endif
                                </div>
                            </div>
                                            
                            <div class="col-md-2">
                                <label class="form-label fw-bold">&nbsp;</label>
                                <div>
                                    <button type="button" class="btn btn-outline-info w-100" onclick="toggleAllFilters()">
                                        <i class="fas fa-chevron-down"></i> Filtros Avanzados
                                    </button>
                                </div>
                            </div>
                        </div>
                                    
                        <div id="filtrosAvanzados" style="display: none;" class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-chart-line"></i> Promedio mínimo
                                </label>
                                <input type="number" 
                                       name="promedio_min" 
                                       class="form-control" 
                                       step="0.01" 
                                       value="{{ request('promedio_min') }}" 
                                       placeholder="Ej: 70">
                            </div>
                                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-chart-line"></i> Promedio máximo
                                </label>
                                <input type="number" 
                                       name="promedio_max" 
                                       class="form-control" 
                                       step="0.01" 
                                       value="{{ request('promedio_max') }}" 
                                       placeholder="Ej: 100">
                            </div>
                                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-venus-mars"></i> Sexo
                                </label>
                                <select name="sexo" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <option value="M" {{ request('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ request('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-city"></i> Ciudad
                                </label>
                                <input type="text" 
                                       name="ciudad" 
                                       class="form-control" 
                                       value="{{ request('ciudad') }}" 
                                       placeholder="Ciudad de origen">
                            </div>
                            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                <button type="submit" class="btn btn-info text-white px-4">
                                    <i class="fas fa-sync-alt"></i> Aplicar Avanzados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive shadow-sm">
                <table class="table table-hover table-bordered align-middle" id="tablaAsignacion">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 60px;" class="text-center">#</th>
                            <th>CI</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Primera Opción</th>
                            <th>Segunda Opción</th>
                            <th>Carrera Asignada</th>
                            <th>Tipo Asignación</th>
                            <th class="text-center">Promedio Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($postulantes as $postulante)
                        @php
                            $esPrimera = ($postulante->carrera_asignada_id == $postulante->primera_carrera_id);
                            $esSegunda = ($postulante->carrera_asignada_id == $postulante->segunda_carrera_id);
                            $enListaEspera = is_null($postulante->carrera_asignada_id);
                        @endphp
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $loop->iteration + ($postulantes->currentPage() - 1) * $postulantes->perPage() }}</td>
                            <td>{{ $postulante->ci }}</td>
                            <td class="fw-bold">{{ $postulante->nombres }} {{ $postulante->apellidos }}</td>
                            <td>{{ $postulante->email }}</td>
                            <td>
                                @if($postulante->primeraCarrera)
                                    <span class="badge bg-success">{{ $postulante->primeraCarrera->nombre }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($postulante->segundaCarrera)
                                    <span class="badge bg-info">{{ $postulante->segundaCarrera->nombre }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($postulante->carreraAsignada)
                                    <strong class="text-primary">{{ $postulante->carreraAsignada->nombre }}</strong>
                                @else
                                    <span class="text-danger fw-bold"><i class="fas fa-ban"></i> No asignado</span>
                                @endif
                            </td>
                            <td>
                                @if($enListaEspera)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-hourglass-half"></i> Lista de Espera
                                    </span>
                                @elseif($esPrimera)
                                    <span class="badge bg-success">
                                        <i class="fas fa-trophy"></i> Primera Opción
                                    </span>
                                @elseif($esSegunda)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-medal"></i> Segunda Opción
                                    </span>
                                @else
                                    <span class="badge bg-danger">Asignación Especial</span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-success">
                                {{ number_format($postulante->promedio_final ?? 0, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fa-2x d-block mb-2 text-secondary"></i>
                                No hay postulantes aprobados con los criterios seleccionados
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $postulantes->appends(request()->query())->links() }}
            </div>
            
            <div class="mt-3 d-flex gap-2">
                <button onclick="exportToExcel()" class="btn btn-success shadow-sm">
                    <i class="fas fa-file-excel"></i> Exportar a Excel
                </button>
                <button onclick="printTable()" class="btn btn-danger shadow-sm">
                    <i class="fas fa-file-pdf"></i> Imprimir / PDF
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

    // Enter en el input de texto activa submit directo
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
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-info-circle"></i>
                <strong>Filtros activos:</strong> ${filtrosActivos.join(', ')}
                <a href="{{ route('reportes.lista') }}" class="btn btn-sm btn-outline-secondary ms-3 py-0">Resetear</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                const existingAlert = document.querySelector('.alert-info');
        if (!existingAlert) {
            const formContainer = document.querySelector('#filtrosForm').parentElement;
            formContainer.insertAdjacentHTML('beforeend', alertHtml);
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
                    th { background-color: #333333; color: #ffffff; }
                    td, th { border: 1px solid #ddd; padding: 8px; }
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
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    th { background-color: #333; color: white; padding: 10px; }
                    td, th { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    table { width: 100%; border-collapse: collapse; }
                    h1 { color: #333; }
                </style>
            </head>
            <body>
                <h1>Reporte de Asignación por Mérito</h1>
                <p>Fecha de emisión: ${new Date().toLocaleString()}</p>
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
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
        .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
        .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
        @media print {
        .btn, .card-header, .alert, form, .pagination {
            display: none !important;
        }
        .card {
            border: none;
            box-shadow: none;
        }
        body {
            padding: 0;
            margin: 0;
        }
    }
</style>
@endpush
@endsection