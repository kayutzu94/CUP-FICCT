@extends('layouts.app')

@section('title', 'Docentes por Grupos')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-chalkboard-user"></i> Docentes por Grupos</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Grupo</th>
                            <th>Aula</th>
                            <th>Docente</th>
                            <th>Materia</th>
                            <th>Estudiantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                            @forelse($grupo->docentesAsignados as $docente)
                                <tr>
                                    <td>{{ $grupo->nombre }} ({{ $grupo->codigo }})</td>
                                    <td>{{ $grupo->aula->nombre ?? 'Sin aula' }}</td>
                                    <td>{{ $docente->nombre_completo }}</td>
                                    <td>{{ $docente->pivot->materia->nombre ?? 'N/A' }}</td>
                                    <td>{{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay docentes asignados a este grupo</td>
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