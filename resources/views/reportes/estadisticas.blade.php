@extends('layouts.app')

@section('title', 'Estadísticas por Materia')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h4><i class="fas fa-chart-bar"></i> Estadísticas por Materia</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-4">
                <canvas id="promediosChart" height="300"></canvas>
            </div>
            <div class="col-md-6 mb-4">
                <canvas id="aprobadosChart" height="300"></canvas>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Materia</th>
                        <th>Promedio General</th>
                        <th>Nota Máxima</th>
                        <th>Nota Mínima</th>
                        <th>Aprobados</th>
                        <th>Reprobados</th>
                        <th>Tasa de Aprobación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estadisticas as $nombre => $data)
                    <tr>
                        <td><strong>{{ $nombre }}</strong></td>
                        <td>{{ number_format($data['promedio'], 2) }}</td>
                        <td>{{ number_format($data['maxima'], 2) }}</td>
                        <td>{{ number_format($data['minima'], 2) }}</td>
                        <td><span class="text-success">{{ $data['aprobados'] }}</span></td>
                        <td><span class="text-danger">{{ $data['reprobados'] }}</span></td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $data['tasa_aprobacion'] }}%">
                                    {{ $data['tasa_aprobacion'] }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="text-end mt-3">
            <a href="{{ route('export.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('export.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar Excel
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const materias = @json(array_keys($estadisticas));
    const promedios = @json(array_column($estadisticas, 'promedio'));
    const aprobados = @json(array_column($estadisticas, 'aprobados'));
    const reprobados = @json(array_column($estadisticas, 'reprobados'));
    
    // Gráfico de promedios
    new Chart(document.getElementById('promediosChart'), {
        type: 'bar',
        data: {
            labels: materias,
            datasets: [{
                label: 'Promedio General',
                data: promedios,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
    
    // Gráfico de aprobados vs reprobados
    new Chart(document.getElementById('aprobadosChart'), {
        type: 'bar',
        data: {
            labels: materias,
            datasets: [
                { label: 'Aprobados', data: aprobados, backgroundColor: 'rgba(40, 167, 69, 0.5)', borderColor: '#28a745', borderWidth: 1 },
                { label: 'Reprobados', data: reprobados, backgroundColor: 'rgba(220, 53, 69, 0.5)', borderColor: '#dc3545', borderWidth: 1 }
            ]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endpush
@endsection