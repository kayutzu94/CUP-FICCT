@extends('layouts.app')

@section('title', 'Mi Panel - Postulante')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                <div class="card-body py-3">
                    <h3 class="mb-0 fw-bold text-white"><i class="fas fa-user-graduate me-2"></i>Mi Panel - Postulante</h3>
                    <p class="mb-0 mt-1 text-white-50">Bienvenido, {{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Datos Personales -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2" style="color: #0a2b5e;"></i> Mis Datos Personales</h5>
                </div>
                <div class="card-body">
                    @if(isset($postulante) && $postulante)
                        <table class="table table-bordered">
                            <tr><th>CI</th><td>{{ $postulante->ci }}</td></tr>
                            <tr><th>Nombres</th><td>{{ $postulante->nombres }}</td></tr>
                            <tr><th>Apellidos</th><td>{{ $postulante->apellidos }}</td></tr>
                            <tr><th>Email</th><td>{{ $postulante->email }}</td></tr>
                            <tr><th>Carrera Asignada</th><td>{{ $postulante->carreraAsignada->nombre ?? 'Pendiente' }}</td></tr>
                            <tr><th>Estado</th>
                                <td>
                                    @if($postulante->estado_academico == 'aprobado')
                                        <span class="badge bg-success">APROBADO</span>
                                    @elseif($postulante->estado_academico == 'reprobado')
                                        <span class="badge bg-danger">REPROBADO</span>
                                    @else
                                        <span class="badge bg-warning">INSCRITO</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Promedio Final</th><td>{{ number_format($postulante->promedio_final ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-warning">No se encontraron datos del postulante</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grupo y Horarios -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-layer-group me-2" style="color: #0a2b5e;"></i> Mi Grupo y Horarios</h5>
                </div>
                <div class="card-body">
                    @if(isset($grupo) && $grupo)
                        <p><strong>Grupo Asignado:</strong> {{ $grupo->nombre }} ({{ $grupo->codigo }})</p>
                        <p><strong>Estudiantes en el grupo:</strong> {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }}</p>
                        <hr>
                        <h6>Horario de Clases</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr><th>Materia</th><th>Día</th><th>Hora</th><th>Aula</th><th>Docente</th></tr>
                                </thead>
                                <tbody>
                                    @forelse(($horarios ?? []) as $horario)
                                    <tr>
                                        <td>{{ $horario->materia->nombre ?? 'N/A' }}</td>
                                        <td>{{ $horario->dia }}</td>
                                        <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                                        <td>{{ $horario->aula->nombre ?? 'N/A' }}</td>
                                        <td>{{ $horario->docente->nombre_completo ?? 'N/A' }}</td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">No hay horarios asignados para tu grupo</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">Aún no tienes grupo asignado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Mis Notas -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2" style="color: #0a2b5e;"></i> Mis Calificaciones</h5>
                </div>
                <div class="card-body">
                    @if(isset($postulante) && $postulante && $postulante->evaluaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Examen 1</th>
                                        <th>Examen 2</th>
                                        <th>Examen 3</th>
                                        <th>Promedio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postulante->evaluaciones as $evaluacion)
                                    <tr>
                                        <td>{{ $evaluacion->materia->nombre }}</td>
                                        <td>{{ $evaluacion->examen1 ?? '-' }}</td>
                                        <td>{{ $evaluacion->examen2 ?? '-' }}</td>
                                        <td>{{ $evaluacion->examen3 ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ ($evaluacion->promedio ?? 0) >= 60 ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($evaluacion->promedio ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($evaluacion->estado == 'aprobado')
                                                <span class="badge bg-success">APROBADO</span>
                                            @elseif($evaluacion->estado == 'reprobado')
                                                <span class="badge bg-danger">REPROBADO</span>
                                            @else
                                                <span class="badge bg-warning">PENDIENTE</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No hay calificaciones registradas aún</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body py-3 text-center">
                    <p class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Sistema de Admisión Universitaria - Facultad FICCT
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection