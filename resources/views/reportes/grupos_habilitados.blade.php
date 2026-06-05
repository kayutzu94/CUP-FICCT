@extends('layouts.app')

@section('title', 'Cantidad de Grupos Habilitados')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4><i class="fas fa-calculator"></i> Cantidad de Grupos Habilitados</h4>
        </div>
        <div class="card-body">
            
            <!-- Tarjetas resumen -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h5>Total Inscritos</h5>
                            <h2>{{ number_format($totalInscritos) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body text-center">
                            <h5>Capacidad por Grupo</h5>
                            <h2>70</h2>
                            <small>estudiantes por grupo</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5>Grupos Necesarios</h5>
                            <h2>{{ $gruposNecesarios }}</h2>
                            <small>Fórmula: CEIL({{ $totalInscritos }}/70)</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5>Grupos Actuales</h5>
                            <h2>{{ $totalGrupos }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Capacidad total -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6>Capacidad Total del Sistema</h6>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ ($capacidadUtilizada / $capacidadTotal) * 100 }}%">
                                    Ocupado: {{ $capacidadUtilizada }} estudiantes
                                </div>
                                <div class="progress-bar bg-secondary" role="progressbar" 
                                     style="width: {{ ($capacidadLibre / $capacidadTotal) * 100 }}%">
                                    Libre: {{ $capacidadLibre }} cupos
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <strong>Capacidad Total:</strong> {{ $capacidadTotal }} estudiantes 
                                ({{ $totalGrupos }} grupos x 70)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabla de grupos -->
            <div class="table-responsive">
                <h5>Distribución de Estudiantes por Grupo</h5>
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Grupo</th>
                            <th>Código</th>
                            <th>Estudiantes Actuales</th>
                            <th>Capacidad Máxima</th>
                            <th>Ocupación</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupos as $grupo)
                        <tr>
                            <td>{{ $grupo->nombre }}</td>
                            <td>{{ $grupo->codigo }}</td>
                            <td>{{ $grupo->postulantes_count }}</td>
                            <td>{{ $grupo->capacidad_maxima }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    @php
                                        $porcentaje = ($grupo->postulantes_count / $grupo->capacidad_maxima) * 100;
                                    @endphp
                                    <div class="progress-bar {{ $porcentaje >= 90 ? 'bg-danger' : ($porcentaje >= 70 ? 'bg-warning' : 'bg-success') }}" 
                                         role="progressbar" 
                                         style="width: {{ $porcentaje }}%">
                                        {{ number_format($porcentaje, 1) }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($grupo->postulantes_count >= $grupo->capacidad_maxima)
                                    <span class="badge bg-danger">Completo</span>
                                @elseif($grupo->postulantes_count >= $grupo->capacidad_maxima * 0.7)
                                    <span class="badge bg-warning">Casi lleno</span>
                                @else
                                    <span class="badge bg-success">Disponible</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Fórmula -->
            <div class="alert alert-info mt-3">
                <strong>📐 Fórmula utilizada:</strong>
                <code>Cantidad de Grupos = CEIL(Total Inscritos / 70)</code>
                <br>
                <strong>Ejemplo:</strong> {{ $totalInscritos }} inscritos ÷ 70 = {{ $totalInscritos / 70 }} → CEIL = {{ $gruposNecesarios }} grupos necesarios.
            </div>
            
            <div class="text-end">
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
</div>
@endsection