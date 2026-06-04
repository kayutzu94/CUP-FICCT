@extends('layouts.app')

@section('title', 'Mi Carga Horaria')

@section('header', 'Mi Carga Horaria')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-clock"></i> Horario de Clases</h5>
        </div>
        <div class="card-body">
            @if($cargaHoraria->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="fas fa-info-circle"></i> No tienes horarios asignados aún.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Grupo</th>
                                <th>Materia</th>
                                <th>Aula</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cargaHoraria as $horario)
                            <tr>
                                <td>{{ $horario->dia }}</td>
                                <td>{{ $horario->hora_inicio }}</td>
                                <td>{{ $horario->hora_fin }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $horario->grupo->nombre ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $horario->materia->nombre ?? 'N/A' }}</td>
                                <td>{{ $horario->aula->nombre ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection