@extends('layouts.app')

@section('title', 'Estadísticas por Materia')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-chart-bar fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Estadísticas Analíticas por Materia</h4>
                    <p class="mb-0 text-white-50 small mt-1">Monitoreo de rendimientos globales, promedios de corte e indicadores cuantitativos de aprobación</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-4 mb-4">
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white p-3 h-100">
                        <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider d-block mb-3">
                            <i class="fas fa-graduation-cap me-1 text-info-custom"></i> Promedios Generales por Asignatura
                        </span>
                        <div class="chart-container position-relative" style="height: 280px;">
                            <canvas id="promediosChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-2xs rounded-3 bg-white p-3 h-100">
                        <span class="text-muted font-size-xs fw-bold text-uppercase tracking-wider d-block mb-3">
                            <i class="fas fa-users me-1 text-primary-custom"></i> Balance Cuantitativo: Aprobados vs Reprobados
                        </span>
                        <div class="chart-container position-relative" style="height: 280px;">
                            <canvas id="aprobadosChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">Materia / Módulo</th>
                            <th class="text-center py-3">Promedio General</th>
                            <th class="text-center py-3">Nota Máxima</th>
                            <th class="text-center py-3">Nota Mínima</th>
                            <th class="text-center py-3" style="width: 110px;">Aprobados</th>
                            <th class="text-center py-3" style="width: 110px;">Reprobados</th>
                            <th class="py-3 px-3" style="min-width: 180px; width: 220px;">Tasa de Aprobación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estadisticas as $nombre => $data)
                        <tr class="row-hover-effect">
                            <td class="px-3">
                                <strong class="text-dark font-size-sm d-block py-1">{{ $nombre }}</strong>
                            </td>
                            <td class="text-center fw-bold text-primary-custom font-monospace font-size-sm">
                                {{ number_format($data['promedio'], 2) }}
                            </td>
                            <td class="text-center font-monospace font-size-sm text-secondary">
                                {{ number_format($data['maxima'], 2) }}
                            </td>
                            <td class="text-center font-monospace font-size-sm text-secondary">
                                {{ number_format($data['minima'], 2) }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-success border-opacity-10 w-75">
                                    {{ $data['aprobados'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace border border-danger border-opacity-10 w-75">
                                    {{ $data['reprobados'] }}
                                </span>
                            </td>
                            <td class="px-3">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="progress rounded-pill flex-fill shadow-3xs" style="height: 12px;">
                                        <div class="progress-bar bg-success rounded-pill" 
                                             role="progressbar" 
                                             style="width: {{ $data['tasa_aprobacion'] }}%"
                                             aria-valuenow="{{ $data['tasa_aprobacion'] }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="font-size-xs font-monospace fw-bold text-dark" style="min-width: 45px; text-align: right;">
                                        {{ $data['tasa_aprobacion'] }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 pt-3 border-top d-flex flex-wrap gap-2 justify-content-end">
                <a href="{{ route('export.excel') }}" class="btn btn-success font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto text-center">
                    <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                </a>
                <a href="{{ route('export.pdf') }}" class="btn btn-danger font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto text-center">
                    <i class="fas fa-file-pdf me-1"></i> Exportar Reporte PDF
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Variables mapeadas de forma explícita sin alteraciones funcionales
    const materias = @json(array_keys($estadisticas));
    const promedios = @json(array_column($estadisticas, 'promedio'));
    const aprobados = @json(array_column($estadisticas, 'aprobados'));
    const reprobados = @json(array_column($estadisticas, 'reprobados'));
    
    // Configuración global estética de fuentes para Chart.js
    Chart.defaults.font.family = 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif';
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#6c757d';

    // Instancia: Gráfico de Promedios Generales
    new Chart(document.getElementById('promediosChart'), {
        type: 'bar',
        data: {
            labels: materias,
            datasets: [{
                label: 'Promedio General',
                data: promedios,
                backgroundColor: 'rgba(10, 43, 94, 0.75)',
                borderColor: '#0a2b5e',
                borderWidth: 1,
                borderRadius: 4,
                barThickness: 28
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    max: 100,
                    grid: { color: 'rgba(0, 0, 0, 0.04)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    
    // Instancia: Gráfico Comparativo Aprobados vs Reprobados
    new Chart(document.getElementById('aprobadosChart'), {
        type: 'bar',
        data: {
            labels: materias,
            datasets: [
                { 
                    label: 'Aprobados', 
                    data: aprobados, 
                    backgroundColor: 'rgba(40, 167, 69, 0.75)', 
                    borderColor: '#28a745', 
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 16
                },
                { 
                    label: 'Reprobados', 
                    data: reprobados, 
                    backgroundColor: 'rgba(220, 53, 69, 0.75)', 
                    borderColor: '#dc3545', 
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 16
                }
            ]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12, padding: 15 } }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.04)' }
                },
                x: {
                    grid: { display: false }
                }
            } 
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Arquitectura visual adaptativa */
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

    /* Esquema de Badges e intensidades */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-info-custom { color: #117a8b; }

    /* Estructuras utilitarias de consistencia */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .gap-2.5 { gap: 0.65rem; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .tracking-wider { letter-spacing: 0.05em; }

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