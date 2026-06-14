@extends('layouts.app')

@section('title', 'Cupos por Carrera')

@section('header', '📚 Cupos por Carrera')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                        <i class="fas fa-chart-pie fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white">Distribución de Cupos</h4>
                        <p class="mb-0 text-white-50 small mt-1">Monitoreo en tiempo real de vacantes, ocupación y estados de admisión por carrera</p>
                    </div>
                </div>
                <div>
                    <button onclick="location.reload()" class="btn btn-light btn-sm text-primary-custom font-size-sm fw-bold px-3 py-1.8 rounded-3 shadow-2xs border-0 hover-up">
                        <i class="fas fa-sync-alt me-1"></i> Actualizar Datos
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">Carrera / Programa</th>
                            <th class="text-center py-3" style="width: 120px;">Inscritos</th>
                            <th class="text-center py-3" style="width: 150px;">Capacidad Máxima</th>
                            <th class="text-center py-3" style="width: 130px;">Cupos Libres</th>
                            <th class="text-center py-3" style="min-width: 180px;">Ocupación</th>
                            <th class="text-center py-3" style="width: 130px;">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carreras as $carrera)
                        @php
                            $cuposLibres = $carrera->capacidad_maxima - $carrera->inscritos_actuales;
                            $porcentaje = $carrera->capacidad_maxima > 0 
                                ? round(($carrera->inscritos_actuales / $carrera->capacidad_maxima) * 100, 1) 
                                : 0;
                            
                            // Color dinámico de la barra e intensidades de badges
                            $barraColor = $porcentaje >= 90 ? 'bg-danger' : ($porcentaje >= 70 ? 'bg-warning' : 'bg-success');
                            $textColor = ($porcentaje >= 70 && $barraColor == 'bg-warning') ? 'text-dark' : 'text-white';
                        @endphp
                        <tr class="row-hover-effect">
                            <td class="px-3">
                                <div class="fw-bold text-dark font-size-sm">{{ $carrera->nombre }}</div>
                                @if($carrera->codigo)
                                    <span class="badge bg-light text-secondary border font-size-2xs font-monospace mt-1 px-2 py-0.5">{{ $carrera->codigo }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-soft text-primary-custom px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-primary border-opacity-10 font-monospace">
                                    {{ $carrera->inscritos_actuales }}
                                </span>
                            </td>
                            <td class="text-center fw-semibold text-secondary font-monospace font-size-sm">
                                {{ $carrera->capacidad_maxima }}
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $cuposLibres > 0 ? 'bg-success-soft text-success border border-success' : 'bg-danger-soft text-danger border border-danger' }} border-opacity-10 px-2.5 py-1.5 rounded-pill font-size-xs fw-bold font-monospace">
                                    {{ $cuposLibres }}
                                </span>
                            </td>
                            <td class="text-center px-3">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="progress rounded-pill flex-fill shadow-3xs" style="height: 16px;">
                                        <div class="progress-bar {{ $barraColor }} {{ $textColor }} rounded-pill font-size-2xs fw-bold" 
                                             role="progressbar" 
                                             style="width: {{ $porcentaje }}%;" 
                                             aria-valuenow="{{ $porcentaje }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                             @if($porcentaje > 15) {{ $porcentaje }}% @endif
                                        </div>
                                    </div>
                                    @if($porcentaje <= 15)
                                        <span class="font-size-2xs font-monospace fw-bold text-muted">{{ $porcentaje }}%</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if($carrera->tieneCupoDisponible())
                                    <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-success border-opacity-10">
                                        <i class="fas fa-check-circle me-1"></i> Disponible
                                    </span>
                                @else
                                    <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-xs fw-bold border border-danger border-opacity-10">
                                        <i class="fas fa-ban me-1"></i> Lleno
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 bg-white bg-opacity-50">
                                <div class="py-3">
                                    <i class="fas fa-layer-group text-muted fa-3x mb-3 opacity-40"></i>
                                    <h5 class="text-muted fw-normal">No hay carreras o facultades registradas</h5>
                                    <p class="text-muted small mb-0">Introduzca datos válidos mediante los módulos correspondientes o ejecute las migraciones iniciales.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mt-4 mb-0 d-flex align-items-start p-3">
                <i class="fas fa-info-circle fa-lg me-2.5 mt-0.5"></i>
                <div class="small">
                    <strong>📌 Recordatorio del sistema:</strong> La asignación de postulantes se realiza de manera estrictamente parametrizada por orden de mérito (mejor promedio general primero). Los cupos libres se recalculan automáticamente al ejecutar el comando consolidado en consola:
                    <code class="bg-white px-2 py-0.5 rounded border font-size-xs font-monospace text-primary-custom d-inline-block mt-1 mt-sm-0 ms-sm-1">php artisan asignar:carreras</code>
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

    /* Animación de la barra de progreso */
    .progress-bar {
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        text-shadow: 0 1px 1px rgba(0,0,0,0.15);
    }

    /* Colores e intensidades suaves para Badges */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .text-primary-custom { color: #0a2b5e; }

    /* Utilidades adaptables fijos */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-1.8 { padding-top: 0.45rem; padding-bottom: 0.45rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush