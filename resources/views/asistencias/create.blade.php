@extends('layouts.app')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h4><i class="fas fa-check-circle"></i> Registrar Asistencia de Estudiantes</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <form method="POST" action="{{ route('asistencias.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Seleccionar Grupo <span class="text-danger">*</span></label>
                    <select name="grupo_id" id="grupo_id" class="form-control" required>
                        <option value="">Seleccione un grupo</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }} ({{ $grupo->codigo }}) - {{ $grupo->estudiantes_actuales }} estudiantes</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Fecha <span class="text-danger">*</span></label>
                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            
            <div id="estudiantes-container" style="display: none;">
                <hr>
                <h5>Lista de Estudiantes</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>CI</th>
                                <th>Nombre Completo</th>
                                <th>Carrera</th>
                                <th>Presente</th>
                            </tr>
                        </thead>
                        <tbody id="estudiantes-table">
                            <tr>
                                <td colspan="4" class="text-center">Seleccione un grupo para cargar los estudiantes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Asistencia
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('grupo_id').addEventListener('change', function() {
        var grupoId = this.value;
        if (grupoId) {
            fetch(`/api/grupos/${grupoId}/estudiantes`)
                .then(response => response.json())
                .then(data => {
                    var tbody = document.getElementById('estudiantes-table');
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay estudiantes en este grupo</td></tr>';
                    } else {
                        data.forEach(estudiante => {
                            var row = tbody.insertRow();
                            row.innerHTML = `
                                <td>${estudiante.ci}</td>
                                <td>${estudiante.nombres} ${estudiante.apellidos}</td>
                                <td>${estudiante.carrera_asignada?.nombre || 'N/A'}</td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" name="asistencias[${estudiante.id}]" value="1" class="form-check-input">
                                        <label class="form-check-label">Presente</label>
                                        <input type="hidden" name="asistencias[${estudiante.id}]" value="0">
                                    </div>
                                </td>
                            `;
                        });
                    }
                    
                    document.getElementById('estudiantes-container').style.display = 'block';
                });
        } else {
            document.getElementById('estudiantes-container').style.display = 'none';
        }
    });
</script>
@endpush
@endsection