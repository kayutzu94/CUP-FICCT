@extends('layouts.app')

@section('title', 'Mi Panel - Postulante')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
        <div class="card-body p-4 text-white">
            <h3 class="fw-bold mb-1"><i class="fas fa-user-graduate me-2"></i>Bienvenido, {{ Auth::user()->name }}</h3>
            <p class="mb-0 text-white-75 font-size-sm">Panel de control de postulante - Facultad FICCT</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-user text-primary-custom me-1"></i> Información Personal
                    </span>
                    @if(isset($postulante) && $postulante)
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-secondary font-size-xs">Cédula de Identidad:</span>
                                <span class="fw-bold font-size-sm">{{ $postulante->ci }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-secondary font-size-xs">Nombres y Apellidos:</span>
                                <span class="fw-bold font-size-sm text-end">{{ $postulante->nombres }} {{ $postulante->apellidos }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-secondary font-size-xs">Correo Electrónico:</span>
                                <span class="fw-bold font-size-sm text-primary-custom">{{ $postulante->email }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-secondary font-size-xs">Carrera Asignada:</span>
                                <span class="fw-bold font-size-sm">{{ $postulante->carreraAsignada->nombre ?? 'Pendiente' }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-secondary font-size-xs">Estado Académico:</span>
                                <span class="badge {{ $postulante->estado_academico == 'aprobado' ? 'bg-success-soft text-success' : 'bg-warning-soft text-warning' }} rounded-pill px-3">
                                    {{ strtoupper($postulante->estado_academico ?? 'INSCRITO') }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 rounded-3">No existen datos de postulante asociados a esta cuenta.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-layer-group text-primary-custom me-1"></i> Carga Académica Asignada
                    </span>
                    @if(isset($grupo) && $grupo)
                        <div class="mb-3">
                            <h5 class="fw-bold text-dark">{{ $grupo->nombre }} <small class="text-muted">({{ $grupo->codigo }})</small></h5>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-primary-custom" style="width: {{ ($grupo->estudiantes_actuales/$grupo->capacidad_maxima)*100 }}%"></div>
                            </div>
                            <small class="text-muted font-size-2xs mt-1 d-block">Ocupación: {{ $grupo->estudiantes_actuales }} de {{ $grupo->capacidad_maxima }} estudiantes</small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-0 font-size-xs">
                                <thead>
                                    <tr class="text-secondary"><th>Materia</th><th>Hora</th><th>Aula</th></tr>
                                </thead>
                                <tbody>
                                    @foreach(($horarios ?? []) as $horario)
                                    <tr>
                                        <td>{{ $horario->materia->nombre ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</td>
                                        <td>{{ $horario->aula->nombre ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info border-0 rounded-3 text-primary-custom bg-primary-soft">Aún no tiene un grupo asignado en el sistema.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                <i class="fas fa-clipboard-list text-primary-custom me-1"></i> Registro de Calificaciones
            </span>
            @if(isset($postulante) && $postulante->evaluaciones->count() > 0)
                <div class="table-responsive rounded-3 border">
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
                                <td class="text-center font-monospace">{{ $eval->examen1 ?? '-' }}</td>
                                <td class="text-center font-monospace">{{ $eval->examen2 ?? '-' }}</td>
                                <td class="text-center font-monospace">{{ $eval->examen3 ?? '-' }}</td>
                                <td class="text-center fw-bold text-dark">{{ number_format($eval->promedio ?? 0, 1) }}</td>
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
            @else
                <div class="text-center py-4 text-muted font-size-sm">No existen registros de calificaciones disponibles.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-primary-custom { background-color: #0a2b5e; color: white; border: none; }
    .bg-primary-custom { background-color: #0a2b5e; }
    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .text-white-75 { color: rgba(255, 255, 255, 0.75); }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endpush