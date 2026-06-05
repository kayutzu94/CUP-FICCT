@extends('layouts.app')

@section('title', 'Promedios Generales')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-chart-line"></i> Promedios Generales</h4>
        </div>
        <div class="card-body">
            <!-- Tarjetas resumen -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5>Promedio General</h5>
                            <h2>{{ number_format($promedioGeneral, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5>Aprobados</h5>
                            <h2>{{ $totalAprobados }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h5>Reprobados</h5>
                            <h2>{{ $totalReprobados }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de postulantes -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>CI</th>
                            <th>Nombre</th>
                            <th>Carrera Asignada</th>
                            <th>Promedio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($postulantes as $p)
                        <tr>
                            <td>{{ $p->ci }}</td>
                            <td>{{ $p->nombres }} {{ $p->apellidos }}</td>
                            <td>{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $p->promedio_final >= 60 ? 'bg-success' : 'bg-danger' }}">
                                    {{ number_format($p->promedio_final ?? 0, 2) }}
                                </span>
                            </td>
                            <td>
                                @if($p->estado_academico == 'aprobado')
                                    <span class="badge bg-success">APROBADO</span>
                                @else
                                    <span class="badge bg-danger">REPROBADO</span>
                                @endif
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