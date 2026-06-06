@extends('layouts.app')

@section('title', 'Aprobados y Reprobados')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-chart-line"></i> Reporte de Aprobados y Reprobados</h4>
        </div>
        <div class="card-body">
            <!-- Tarjetas resumen -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5>Total Aprobados</h5>
                            <h2>{{ $totalAprobados }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h5>Total Reprobados</h5>
                            <h2>{{ $totalReprobados }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5>Tasa de Aprobación</h5>
                            <h2>{{ number_format($tasaAprobacion, 1) }}%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Aprobados -->
            <h5 class="mt-4 text-success">📋 Postulantes Aprobados</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>CI</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Carrera Asignada</th>
                            <th>Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aprobados as $p)
                        <tr>
                            <td>{{ $p->ci }}</td>
                            <td>{{ $p->nombres }}</td>
                            <td>{{ $p->apellidos }}</td>
                            <td>{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                            <td><span class="badge bg-success">{{ number_format($p->promedio_final ?? 0, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Tabla de Reprobados -->
            <h5 class="mt-4 text-danger">⚠️ Postulantes Reprobados</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>CI</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Carrera Asignada</th>
                            <th>Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reprobados as $p)
                        <tr>
                            <td>{{ $p->ci }}</td>
                            <td>{{ $p->nombres }}</td>
                            <td>{{ $p->apellidos }}</td>
                            <td>{{ $p->carreraAsignada->nombre ?? 'N/A' }}</td>
                            <td><span class="badge bg-danger">{{ number_format($p->promedio_final ?? 0, 2) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection