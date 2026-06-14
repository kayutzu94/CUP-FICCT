@extends('layouts.app')

@section('title', 'Gestión de Cupo y Asignación')

@section('content')
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-chart-line text-primary me-2"></i> Control de Admisión</h2>
            <p class="text-muted mb-0">Gestión y monitoreo de cupo por carrera académica</p>
        </div>
        <form action="/cupos/asignar" method="POST" onsubmit="return confirm('¿Estás seguro de ejecutar la asignación por mérito?')">
            @csrf
            <button type="submit" class="btn btn-light w-100">
                <i class="fas fa-play"></i> Asignar por Mérito
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
            
    <div class="row g-3 mb-4">
        <div class="col-md-8">
            <div class="row g-3">
                @php
                    $stats = [
                        ['label' => 'Total Aprobados', 'val' => $totalAprobados, 'color' => 'primary', 'icon' => 'user-graduate'],
                        ['label' => 'Asignados', 'val' => $totalAsignados, 'color' => 'success', 'icon' => 'user-check'],
                        ['label' => 'Lista de Espera', 'val' => $totalEspera, 'color' => 'warning', 'icon' => 'clock'],
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-{{ $stat['color'] }} bg-opacity-10 text-{{ $stat['color'] }} rounded-3 p-3 me-3">
                                <i class="fas fa-{{ $stat['icon'] }} fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small mb-0">{{ $stat['label'] }}</h6>
                                <h3 class="fw-bold mb-0">{{ $stat['val'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white border-start border-4 border-primary">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="text-muted text-uppercase small mb-2">Procesos</h6>
                        <h5 class="fw-bold mb-2">Ejecutar Asignación</h5>
                        <p class="small text-muted mb-3">Reajustará todo el cupo automáticamente según promedios.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Carrera</th>
                            <th class="text-center">Cupo Total</th>
                            <th class="text-center">Asignados</th>
                            <th class="text-center">Disponibles</th>
                            <th class="text-center">Ocupación</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carreras as $carrera)
                        @php
                            $cupo = $carrera->cupo ?? 0;
                            $asignados = $carrera->postulantes_asignados_count ?? 0;
                            $disponibles = $cupo - $asignados;
                            $porcentaje = $cupo > 0 ? round(($asignados / $cupo) * 100, 2) : 0;
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold">{{ $carrera->nombre }}</td>
                            <td class="text-center"><span class="badge bg-primary rounded-pill px-3">{{ $cupo }}</span></td>
                            <td class="text-center"><span class="badge bg-warning rounded-pill px-3">{{ $asignados }}</span></td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 bg-{{ $disponibles > 0 ? 'success' : 'danger' }}">
                                    {{ $disponibles }}
                                </span>
                            </td>
                            <td class="px-3" style="width: 150px;">
                                <div class="progress rounded-pill" style="height: 10px;">
                                    <div class="progress-bar rounded-pill bg-{{ $porcentaje == 100 ? 'danger' : ($porcentaje >= 80 ? 'warning' : 'success') }}" 
                                         style="width: {{ $porcentaje }}%"></div>
                                </div>
                                <small class="text-muted d-block text-center mt-1">{{ $porcentaje }}%</small>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editCupoModal{{ $carrera->id }}">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($carreras as $carrera)
<div class="modal fade" id="editCupoModal{{ $carrera->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('cupo.update', $carrera) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Editar Cupo - {{ $carrera->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Cupo total:</label>
                    <input type="number" name="cupo" class="form-control rounded-3" value="{{ $carrera->cupo ?? 0 }}" required min="0" max="200">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection