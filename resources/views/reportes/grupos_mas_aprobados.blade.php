@extends('layouts.app')

@section('title', 'Grupos con Más Aprobados')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-trophy"></i> Ranking - Grupos con Más Aprobados</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Grupo</th>
                            <th>Total Estudiantes</th>
                            <th>Aprobados</th>
                            <th>Reprobados</th>
                            <th>Tasa de Aprobación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $index => $grupo)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $grupo->nombre }}</strong><br>
                                <small class="text-muted">{{ $grupo->codigo }}</small>
                             </td>
                            <td>{{ $grupo->total_estudiantes }}</td>
                            <td class="text-success fw-bold">{{ $grupo->aprobados }}</td>
                            <td class="text-danger">{{ $grupo->reprobados }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $grupo->tasa_aprobacion }}%">
                                        {{ $grupo->tasa_aprobacion }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection