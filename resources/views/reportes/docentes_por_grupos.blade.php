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
                    <p class="mb-0 text-white-50 small mt-1">Asignación de cátedras, gestión de docentes y aforo de alumnos</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0 datatable">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">Grupo / Código</th>
                            <th class="py-3">Docente</th>
                            <th class="py-3">Materia</th>
                            <th class="py-3">Fecha Asignación</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($asignacionesPorGrupo) && count($asignacionesPorGrupo) > 0)
                            @foreach($asignacionesPorGrupo as $grupoId => $asignacionesDelGrupo)
                                @foreach($asignacionesDelGrupo as $asignacion)
                                    <tr class="row-hover-effect">
                                        <td class="px-3">
                                            <span class="fw-bold text-dark font-size-sm">{{ $asignacion->grupo->nombre }}</span>
                                            <span class="d-block text-muted font-size-2xs font-monospace mt-0.5">ID: {{ $asignacion->grupo->codigo }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark font-size-sm">{{ $asignacion->docente->nombre_completo }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-soft text-primary-custom px-2.5 py-1.5 rounded-3 font-size-xs fw-bold border border-primary border-opacity-10">
                                                {{ $asignacion->materia->nombre }}
                                            </span>
                                        </td>
                                        <td class="font-size-sm text-secondary">
                                            {{ $asignacion->fecha_asignacion ? $asignacion->fecha_asignacion->format('d/m/Y') : 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('asignaciones.destroy', $asignacion->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de desasignar a {{ $asignacion->docente->nombre_completo }} del grupo {{ $asignacion->grupo->nombre }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-soft text-danger border-0 hover-up">
                                                    <i class="fas fa-user-minus me-1"></i> Desasignar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="alert alert-warning mb-0">No existen asignaciones registradas.</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-table-header { background-color: #0a2b5e !important; }
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .row-hover-effect { transition: background-color 0.15s ease; }
    .row-hover-effect:hover { background-color: rgba(10, 43, 94, 0.02) !important; }

    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    
    .text-primary-custom { color: #0a2b5e; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .hover-up { transition: transform 0.2s; }
    .hover-up:hover { transform: translateY(-2px); }
</style>
@endpush