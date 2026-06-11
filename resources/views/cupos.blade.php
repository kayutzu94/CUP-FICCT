@extends('layouts.app')

@section('title', 'Cupos por Carrera')

@section('header', '📚 Cupos por Carrera')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chalkboard-user"></i> Distribución de Cupos
            </h5>
            <div>
                <button onclick="location.reload()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-sync-alt"></i> Actualizar
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Carrera</th>
                            <th class="text-center">Inscritos</th>
                            <th class="text-center">Capacidad Máxima</th>
                            <th class="text-center">Cupos Libres</th>
                            <th class="text-center">Ocupación</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carreras as $carrera)
                        @php
                            $cuposLibres = $carrera->capacidad_maxima - $carrera->inscritos_actuales;
                            $porcentaje = $carrera->capacidad_maxima > 0 
                                ? round(($carrera->inscritos_actuales / $carrera->capacidad_maxima) * 100, 1) 
                                : 0;
                            
                            // Color de la barra de progreso
                            $barraColor = $porcentaje >= 90 ? 'bg-danger' : ($porcentaje >= 70 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $carrera->nombre }}</strong>
                                @if($carrera->codigo)
                                    <br><small class="text-muted">{{ $carrera->codigo }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">{{ $carrera->inscritos_actuales }}</span>
                            </td>
                            <td class="text-center">{{ $carrera->capacidad_maxima }}</td>
                            <td class="text-center">
                                <span class="badge {{ $cuposLibres > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                    {{ $cuposLibres }}
                                </span>
                            </td>
                            <td class="text-center" style="min-width: 150px;">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar {{ $barraColor }}" 
                                         role="progressbar" 
                                         style="width: {{ $porcentaje }}%;" 
                                         aria-valuenow="{{ $porcentaje }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $porcentaje }}%
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($carrera->tieneCupoDisponible())
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Disponible
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i> Completado
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <i class="fas fa-exclamation-triangle"></i> No hay carreras registradas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> 
                <strong>Nota:</strong> La asignación de postulantes se realiza por orden de mérito (mejor promedio primero). 
                Los cupos libres se actualizan automáticamente al ejecutar <code>php artisan asignar:carreras</code>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress-bar {
        transition: width 0.5s ease;
        font-size: 12px;
        line-height: 20px;
        color: #000;
        font-weight: bold;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endpush