@extends('layouts.app')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="container-fluid px-0 py-2">
    
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-3 p-3">
            <i class="fas fa-check-circle fa-lg me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-check-double fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Registrar Asistencia de Estudiantes</h4>
                    <p class="mb-0 text-white-50 small mt-1">Control diario y validación de asistencia en aulas del CUP</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('asistencias.store') }}">
                @csrf
                
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Seleccionar Grupo <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-layer-group"></i></span>
                            <select name="grupo_id" id="grupo_id" class="form-select border font-size-sm" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }} ({{ $grupo->codigo }}) - {{ $grupo->estudiantes_actuales }} estudiantes</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
                        <label class="form-label text-dark fw-medium small">Fecha <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border text-muted"><i class="fas fa-calendar-alt"></i></span>
                            <input type="date" name="fecha" class="form-control border font-size-sm" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                
                <div id="estudiantes-container" class="mt-4 pt-3 border-top fade-in" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="fw-bold text-primary-custom mb-0 d-flex align-items-center">
                            <i class="fas fa-clipboard-list me-2 opacity-75"></i> Lista de Estudiantes
                        </h5>
                        <span class="badge bg-primary-soft text-primary-custom px-3 py-1.5 font-size-xs rounded-pill border border-primary border-opacity-10">
                            Marque la casilla si el alumno está presente
                        </span>
                    </div>

                    <div class="table-responsive rounded-3 border shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="custom-table-header text-white">
                                <tr>
                                    <th class="py-3 px-3" style="width: 140px;">CI</th>
                                    <th class="py-3">Nombre Completo</th>
                                    <th class="py-3">Carrera</th>
                                    <th class="py-3 text-center px-3" style="width: 140px;">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="estudiantes-table">
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Seleccione un grupo para cargar los estudiantes
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-success font-size-sm px-4 py-2.5 rounded-3 fw-bold shadow-sm hover-up">
                            <i class="fas fa-save me-1"></i> Guardar Asistencia
                        </button>
                    </div>
                </div>
            </form>
        </div>
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
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-slash d-block mb-2 fa-2x opacity-50"></i>
                                    No hay estudiantes registrados en este grupo
                                </td>
                            </tr>`;
                    } else {
                        data.forEach(estudiante => {
                            var row = tbody.insertRow();
                            row.className = 'row-hover-effect';
                            
                            var carreraNombre = estudiante.carrera_asignada?.nombre || 'N/A';
                            
                            row.innerHTML = `
                                <td class="px-3 fw-bold text-dark font-monospace">${estudiante.ci}</td>
                                <td class="fw-medium">${estudiante.nombres} ${estudiante.apellidos}</td>
                                <td><span class="badge bg-light text-dark border font-size-xs px-2 py-1.5">${carreraNombre}</span></td>
                                <td class="text-center px-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check form-switch custom-switch-success m-0">
                                            <input type="hidden" name="asistencias[${estudiante.id}]" value="0">
                                            <input type="checkbox" name="asistencias[${estudiante.id}]" value="1" class="form-check-input cursor-pointer" id="chk-${estudiante.id}">
                                            <label class="form-check-label font-size-xs fw-bold text-muted cursor-pointer" for="chk-${estudiante.id}">Falta</label>
                                        </div>
                                    </div>
                                </td>
                            `;
                            
                            // Añadir evento al switch dinámico para cambiar el texto descriptivo dinámicamente
                            var checkbox = row.querySelector(`#chk-${estudiante.id}`);
                            checkbox.addEventListener('change', function() {
                                var label = this.nextElementSibling;
                                if (this.checked) {
                                    label.textContent = 'Presente';
                                    label.classList.replace('text-muted', 'text-success');
                                } else {
                                    label.textContent = 'Falta';
                                    label.classList.replace('text-success', 'text-muted');
                                }
                            });
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

@push('styles')
<style>
    /* Cabecera institucional */
    .custom-table-header {
        background-color: #0a2b5e !important;
    }
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Efecto interactivo en filas */
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Interruptor o Switch personalizado para asistencia */
    .custom-switch-success .form-check-input:checked {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }

    /* Clases utilitarias */
    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    
    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }

    /* Animación de entrada para los estudiantes cargados */
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection