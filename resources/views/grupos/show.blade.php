@extends('layouts.app')

@section('title', 'Estudiantes del Grupo')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                    <i class="fas fa-users fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Nómina del Grupo: {{ $grupo->nombre }}</h4>
                    <p class="mb-0 text-white-50 small mt-1">Listado oficial de postulantes asignados, promedios finales y estados de cumplimiento académico</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if($grupo->postulantes->isEmpty())
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom text-center py-5 mb-0 shadow-3xs">
                    <div class="indicator-circle-bg bg-white bg-opacity-60 text-primary-custom mx-auto mb-3 shadow-3xs" style="width: 52px; height: 52px; font-size: 1.3rem;">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h5 class="fw-bold text-dark font-size-md">Sin estudiantes asignados</h5>
                    <p class="text-secondary small mb-0 max-width-text mx-auto mt-1">
                        Actualmente no existen registros asociados a este grupo. Puede realizar la vinculación desde el módulo de gestión principal usando la opción <strong>"Asignar Automáticamente"</strong>.
                    </p>
                </div>
            @else
                <div class="table-responsive rounded-3 border bg-white shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="custom-table-header text-white">
                            <tr>
                                <th class="py-3 px-3">Cédula (CI)</th>
                                <th class="py-3">Nombres y Apellidos</th>
                                <th class="py-3">Carrera Asignada</th>
                                <th class="py-3 text-center">Promedio</th>
                                <th class="py-3 text-center">Estado Académico</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupo->postulantes as $p)
                            <tr class="row-hover-effect">
                                <td class="px-3 font-monospace font-size-sm text-secondary">{{ $p->ci }}</td>
                                <td>
                                    <div class="fw-bold text-dark font-size-sm">{{ $p->nombres }} {{ $p->apellidos }}</div>
                                </td>
                                <td class="font-size-sm text-secondary">{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                                <td class="text-center font-monospace font-size-sm fw-bold text-dark">{{ number_format($p->promedio_final ?? 0, 2) }}</td>
                                <td class="text-center">
                                    @php
                                        $clase = match($p->estado_academico) {
                                            'aprobado' => 'bg-success-soft text-success border-success',
                                            'reprobado' => 'bg-danger-soft text-danger border-danger',
                                            default => 'bg-warning-soft text-warning border-warning'
                                        };
                                        $texto = ucfirst($p->estado_academico ?? 'Inscrito');
                                    @endphp
                                    <span class="badge {{ $clase }} px-2.5 py-1.5 rounded-3 font-size-2xs fw-bold border border-opacity-20">
                                        {{ $texto }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="pt-4 border-top mt-4 d-flex justify-content-end">
                <a href="{{ route('grupos.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">
                    <i class="fas fa-arrow-left me-1.5 font-size-xs"></i> Volver al Listado
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-table-header { background-color: #0a2b5e !important; }
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.12); }

    .row-hover-effect { transition: background-color 0.15s ease; }
    .row-hover-effect:hover { background-color: rgba(10, 43, 94, 0.02) !important; }
    
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }

    .font-size-sm { font-size: 0.9rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
</style>
@endpush