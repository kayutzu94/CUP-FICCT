@extends('layouts.app')

@section('title', 'Listado de Asistencias')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-calendar-check"></i> Listado de Asistencias</h4>
    </div>
    <div class="card-body">
        @if($asistencias->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No hay registros de asistencia aún.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Grupo</th>
                            <th>Estudiante</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asistencias as $a)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $a->grupo->nombre ?? 'N/A' }} ({{ $a->grupo->codigo ?? '' }})</td>
                            <td>{{ $a->postulante->nombre_completo ?? 'N/A' }}</td>
                            <td>
                                @if($a->presente)
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Presente</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Ausente</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection