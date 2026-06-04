@extends('layouts.app')
@section('title', 'Evaluaciones')
@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h4>Calificaciones - {{ $postulante->nombre_completo }}</h4>
    </div>
    <div class="card-body">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evaluaciones as $evaluacion)
                    <tr>
                        <td><strong>{{ $evaluacion->materia->nombre }}</strong></td>
                        <td>{{ $evaluacion->examen1 ?? '-' }}</td>
                        <td>{{ $evaluacion->examen2 ?? '-' }}</td>
                        <td>{{ $evaluacion->examen3 ?? '-' }}</td>
                        <td>
                            @if($evaluacion->promedio)
                                <span class="badge {{ $evaluacion->promedio >= 60 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($evaluacion->promedio, 2) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Pendiente</span>
                            @endif
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
                        <td>
                            <a href="{{ route('evaluaciones.edit', [$postulante, $evaluacion->materia]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Registrar Notas
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="alert alert-info mt-3">
            <strong>Promedio Final: </strong> {{ number_format($postulante->promedio_final ?? 0, 2) }} |
            <strong>Estado Final: </strong>
            @if($postulante->estado_academico == 'aprobado')
                <span class="badge bg-success">APROBADO</span>
            @elseif($postulante->estado_academico == 'reprobado')
                <span class="badge bg-danger">REPROBADO</span>
            @else
                <span class="badge bg-warning">INSCRITO</span>
            @endif
        </div>
    </div>
</div>
@endsection