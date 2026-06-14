@extends('layouts.app')

@section('title', 'Evaluaciones')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                    <i class="fas fa-clipboard-list fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Historial de Calificaciones</h4>
                    <p class="mb-0 text-white-75 small mt-1">Gestión de exámenes y desempeño académico de: {{ $postulante->nombres }} {{ $postulante->apellidos }}</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="table-responsive rounded-3 border bg-white shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary-custom text-white">
                        <tr class="font-size-xs">
                            <th class="py-3 px-3">MATERIA</th>
                            <th class="text-center">EXAMEN 1</th>
                            <th class="text-center">EXAMEN 2</th>
                            <th class="text-center">EXAMEN 3</th>
                            <th class="text-center">PROMEDIO</th>
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluaciones as $eval)
                        <tr class="font-size-sm">
                            <td class="px-3 fw-bold text-dark">{{ $eval->materia->nombre }}</td>
                            <td class="text-center font-monospace">{{ $eval->examen1 ?? '-' }}</td>
                            <td class="text-center font-monospace">{{ $eval->examen2 ?? '-' }}</td>
                            <td class="text-center font-monospace">{{ $eval->examen3 ?? '-' }}</td>
                            <td class="text-center">
                                @if($eval->promedio)
                                    <span class="badge {{ $eval->promedio >= 60 ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} px-3 rounded-pill">
                                        {{ number_format($eval->promedio, 1) }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-secondary rounded-pill px-3">Pendiente</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $eval->estado == 'aprobado' ? 'bg-success-soft text-success' : ($eval->estado == 'reprobado' ? 'bg-danger-soft text-danger' : 'bg-warning-soft text-warning') }} rounded-pill px-3">
                                    {{ strtoupper($eval->estado ?? 'PENDIENTE') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('evaluaciones.edit', [$postulante, $eval->materia]) }}" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm font-size-xs fw-bold px-3 py-1.5">
                                    <i class="fas fa-edit me-1"></i> Registrar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-6">
                    <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom shadow-3xs p-3.5">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fas fa-chart-line fa-2x opacity-50"></i></div>
                            <div>
                                <span class="d-block font-size-xs fw-bold text-uppercase">Promedio Final del Postulante</span>
                                <span class="h4 mb-0 fw-bold">{{ number_format($postulante->promedio_final ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="alert {{ $postulante->estado_academico == 'aprobado' ? 'bg-success-soft text-success' : ($postulante->estado_academico == 'reprobado' ? 'bg-danger-soft text-danger' : 'bg-warning-soft text-warning') }} border-0 rounded-3 shadow-3xs p-3.5">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fas fa-certificate fa-2x opacity-50"></i></div>
                            <div>
                                <span class="d-block font-size-xs fw-bold text-uppercase">Estado Académico Final</span>
                                <span class="h4 mb-0 fw-bold">{{ strtoupper($postulante->estado_academico ?? 'INSCRITO') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('postulantes.show', $postulante) }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">
                    <i class="fas fa-arrow-left me-1.5"></i> Volver al Perfil
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .bg-primary-custom { background-color: #0a2b5e; }
    .btn-outline-primary { border-color: #0a2b5e; color: #0a2b5e; }
    .btn-outline-primary:hover { background-color: #0a2b5e; color: white; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.12); }
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
</style>
@endpush