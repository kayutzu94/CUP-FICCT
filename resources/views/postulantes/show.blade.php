@extends('layouts.app')

@section('title', 'Detalles del Postulante')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                    <i class="fas fa-user fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Ficha del Postulante: {{ $postulante->nombres }} {{ $postulante->apellidos }}</h4>
                    <p class="mb-0 text-white-75 small mt-1">Expediente completo, historial de evaluaciones y asignación de carrera</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="bg-white rounded-3 border shadow-3xs p-3 h-100">
                        <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3 border-bottom pb-2">
                            <i class="fas fa-id-card text-secondary me-1"></i> Información General
                        </span>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">CI:</span><span class="fw-bold font-size-sm">{{ $postulante->ci }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Nacimiento:</span><span class="fw-bold font-size-sm">{{ \Carbon\Carbon::parse($postulante->fecha_nacimiento)->format('d/m/Y') }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Sexo:</span><span class="fw-bold font-size-sm">{{ $postulante->sexo == 'M' ? 'Masculino' : 'Femenino' }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Email:</span><span class="fw-bold font-size-sm text-primary-custom">{{ $postulante->email }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Teléfono:</span><span class="fw-bold font-size-sm">{{ $postulante->telefono }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="bg-white rounded-3 border shadow-3xs p-3 h-100">
                        <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3 border-bottom pb-2">
                            <i class="fas fa-graduation-cap text-secondary me-1"></i> Estado Académico
                        </span>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Carrera Asignada:</span><span class="fw-bold font-size-sm text-primary-custom">{{ $postulante->carreraAsignada->nombre ?? 'Pendiente' }}</span></div>
                            <div class="d-flex justify-content-between"><span class="text-secondary font-size-xs">Promedio Final:</span><span class="fw-bold font-size-sm">{{ number_format($postulante->promedio_final ?? 0, 2) }}</span></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary font-size-xs">Estado:</span>
                                <span class="badge {{ $postulante->estado_academico == 'aprobado' ? 'bg-success-soft text-success' : 'bg-warning-soft text-warning' }} rounded-pill px-3">
                                    {{ strtoupper($postulante->estado_academico ?? 'INSCRITO') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-clipboard-list text-secondary me-1"></i> Historial de Evaluaciones
                </span>
                <div class="table-responsive rounded-3 border bg-white shadow-sm">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary-custom text-white">
                            <tr class="font-size-xs">
                                <th>MATERIA</th>
                                <th class="text-center">EXAMEN 1</th>
                                <th class="text-center">EXAMEN 2</th>
                                <th class="text-center">EXAMEN 3</th>
                                <th class="text-center">PROMEDIO</th>
                                <th class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($postulante->evaluaciones as $eval)
                            <tr class="font-size-sm">
                                <td class="fw-semibold">{{ $eval->materia->nombre }}</td>
                                <td class="text-center">{{ $eval->examen1 ?? '-' }}</td>
                                <td class="text-center">{{ $eval->examen2 ?? '-' }}</td>
                                <td class="text-center">{{ $eval->examen3 ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ $eval->promedio ?? '0.0' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ ($eval->promedio ?? 0) >= 60 ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} px-3 rounded-pill">
                                        {{ strtoupper($eval->estado ?? 'PENDIENTE') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-4 mt-4 border-top d-flex gap-2 justify-content-end">
                <a href="{{ route('postulantes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">Volver</a>
                <a href="{{ route('evaluaciones.index', $postulante) }}" class="btn btn-primary-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up">
                    <i class="fas fa-clipboard-list me-1.5 font-size-xs"></i> Ver Notas
                </a>
                <a href="{{ route('postulantes.edit', $postulante) }}" class="btn btn-warning-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up text-white">
                    <i class="fas fa-edit me-1.5 font-size-xs"></i> Editar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .btn-primary-custom { background-color: #0a2b5e; color: white; border: none; }
    .btn-warning-custom { background-color: #e0a800; border: none; }
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .bg-primary-custom { background-color: #0a2b5e; }
    .text-primary-custom { color: #0a2b5e; }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .text-white-75 { color: rgba(255, 255, 255, 0.75); }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
</style>
@endpush