@extends('layouts.app')

@section('title', 'Docentes por Grupos')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-chalkboard-user fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Carga Horaria y Docentes por Grupo</h4>
                    <p class="mb-0 text-white-50 small mt-1">Asignación de cátedras, distribución de ambientes pedagógicos y aforo actual de alumnos</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3" style="width: 160px;">Grupo / Código</th>
                            <th class="py-3" style="width: 150px;">Aula / Ubicación</th>
                            <th class="py-3">Docente Asignado</th>
                            <th class="py-3">Materia / Asignatura</th>
                            <th class="text-center py-3" style="width: 160px;">Estudiantes (Aforo)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                            @forelse($grupo->docentesAsignados as $docente)
                                <tr class="row-hover-effect">
                                    <td class="px-3">
                                        <span class="fw-bold text-dark font-size-sm">{{ $grupo->nombre }}</span>
                                        @if($grupo->codigo)
                                            <span class="d-block text-muted font-size-2xs font-monospace mt-0.5">ID: {{ $grupo->codigo }}</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center text-secondary font-size-sm fw-medium">
                                            <i class="fas fa-door-open me-2 text-muted opacity-75 font-size-xs"></i>
                                            {{ $grupo->aula->nombre ?? 'Sin aula asignada' }}
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-semibold text-dark font-size-sm">
                                            {{ $docente->nombre_completo }}
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-primary-soft text-primary-custom px-2.5 py-1.5 rounded-3 font-size-xs fw-bold border border-primary border-opacity-10">
                                            <i class="fas fa-book-reader me-1.5 opacity-70"></i>{{ $docente->pivot->materia->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    
                                    <td class="text-center">
                                        @php
                                            $estaLleno = $grupo->estudiantes_actuales >= $grupo->capacidad_maxima;
                                            $badgeAforoClase = $estaLleno ? 'bg-danger-soft text-danger border border-danger' : 'bg-success-soft text-success border border-success';
                                        @endphp
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <span class="badge {{ $badgeAforoClase }} border-opacity-10 px-2.5 py-1.2 rounded-pill font-size-xs fw-bold font-monospace min-width-aforo">
                                                {{ $grupo->estudiantes_actuales }} / {{ $grupo->capacidad_maxima }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-light bg-opacity-20">
                                    <td class="px-3">
                                        <span class="fw-bold text-dark font-size-sm">{{ $grupo->nombre }}</span>
                                        <span class="d-block text-muted font-size-2xs font-monospace">ID: {{ $grupo->codigo }}</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary font-size-sm">
                                            <i class="fas fa-door-open me-2 text-muted opacity-75 font-size-xs"></i>
                                            {{ $grupo->aula->nombre ?? 'Sin aula' }}
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-muted font-size-xs italic border-end-0">
                                        <i class="fas fa-exclamation-circle text-warning-custom me-1.5"></i> No se registran docentes vinculados a este grupo académico.
                                    </td>
                                    <td class="text-center border-start-0">
                                        <span class="badge bg-secondary-soft text-secondary px-2.5 py-1.2 rounded-pill font-size-xs font-monospace min-width-aforo">
                                            {{ $grupo->estudiantes_actuales }} / {{ $grupo->capacidad_maxima }}
                                        </span>
                                    </td>
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Arquitectura visual estandarizada */
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

    /* Esquemas cromáticos suaves para badges */
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    .text-warning-custom { color: #b78a02 !important; }

    /* Clases utilitarias y tipografías */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-1.2 { padding-top: 0.3rem; padding-bottom: 0.3rem; }
    .me-1.5 { margin-right: 0.35rem; }
    .px-2.5 { padding-left: 0.65rem; padding-right: 0.65rem; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .min-width-aforo { min-width: 85px; display: inline-block; }
    .italic { font-style: italic; }
</style>
@endpush