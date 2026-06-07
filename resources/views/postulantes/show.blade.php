@extends('layouts.app')

@section('title', 'Detalles del Postulante')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-user"></i> Detalles del Postulante</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th style="width: 40%;">CI</th><td>{{ $postulante->ci }}</td></tr>
                        <tr><th>Nombres</th><td>{{ $postulante->nombres }}</td></tr>
                        <tr><th>Apellidos</th><td>{{ $postulante->apellidos }}</td></tr>
                        <tr><th>Fecha Nacimiento</th><td>{{ \Carbon\Carbon::parse($postulante->fecha_nacimiento)->format('d/m/Y') }}</td></tr>
                        <tr><th>Sexo</th><td>{{ $postulante->sexo == 'M' ? 'Masculino' : 'Femenino' }}</td></tr>
                        <tr><th>Email</th><td>{{ $postulante->email }}</td></tr>
                        <tr><th>Teléfono</th><td>{{ $postulante->telefono }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th style="width: 40%;">Dirección</th><td>{{ $postulante->direccion }}</td></tr>
                        <tr><th>Ciudad</th><td>{{ $postulante->ciudad }}</td></tr>
                        <tr><th>Colegio</th><td>{{ $postulante->colegio }}</td></tr>
                        <tr><th>Título Bachiller</th><td>{{ $postulante->titulo_bachiller }}</td></tr>
                        <tr><th>Primera Carrera</th><td>{{ $postulante->primeraCarrera->nombre ?? 'N/A' }}</td></tr>
                        <tr><th>Segunda Carrera</th><td>{{ $postulante->segundaCarrera->nombre ?? 'N/A' }}</td></tr>
                        <tr><th>Carrera Asignada</th><td><span class="badge bg-info">{{ $postulante->carreraAsignada->nombre ?? 'Pendiente' }}</span></td></tr>
                        <tr><th>Promedio Final</th><td>
                            <span class="badge {{ $postulante->promedio_final >= 60 ? 'bg-success' : 'bg-danger' }}">
                                {{ number_format($postulante->promedio_final ?? 0, 2) }}
                            </span>
                        </td></tr>
                        <tr><th>Estado</th><td>
                            @if($postulante->estado_academico == 'aprobado')
                                <span class="badge bg-success">APROBADO</span>
                            @elseif($postulante->estado_academico == 'reprobado')
                                <span class="badge bg-danger">REPROBADO</span>
                            @else
                                <span class="badge bg-warning">INSCRITO</span>
                            @endif
                        </td></tr>
                    </table>
                </div>
            </div>

            <h5 class="mt-4">Calificaciones por Materia</h5>
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
                                <span class="badge {{ ($evaluacion->promedio ?? 0) >= 60 ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $evaluacion->promedio ?? 'Pendiente' }}
                                </span>
                            </td>
                            <td>
                                @if($evaluacion->estado == 'aprobado')
                                    <span class="badge bg-success">Aprobado</span>
                                @elseif($evaluacion->estado == 'reprobado')
                                    <span class="badge bg-danger">Reprobado</span>
                                @else
                                    <span class="badge bg-warning">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('postulantes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <a href="{{ route('postulantes.edit', $postulante) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('evaluaciones.index', $postulante) }}" class="btn btn-info">
                    <i class="fas fa-clipboard-list"></i> Ver Notas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection