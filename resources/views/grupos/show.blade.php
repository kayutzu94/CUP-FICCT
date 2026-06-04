@extends('layouts.app')
@section('title', 'Estudiantes del Grupo')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Estudiantes del Grupo: {{ $grupo->nombre }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>CI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Carrera Asignada</th>
                        <th>Promedio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupo->postulantes as $p)
                    <tr>
                        <td>{{ $p->ci }}</td>
                        <td>{{ $p->nombres }}</td>
                        <td>{{ $p->apellidos }}</td>
                        <td>{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                        <td>{{ number_format($p->promedio_final ?? 0, 2) }}</td>
                        <td>
                            @if($p->estado_academico == 'aprobado')
                                <span class="badge bg-success">Aprobado</span>
                            @elseif($p->estado_academico == 'reprobado')
                                <span class="badge bg-danger">Reprobado</span>
                            @else
                                <span class="badge bg-warning">Inscrito</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection