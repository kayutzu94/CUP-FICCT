@extends('layouts.app')

@section('title', 'Registrar Notas')

@section('content')
<div class="container-fluid px-0 py-2">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                            <i class="fas fa-edit fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Registro de Calificaciones</h5>
                            <p class="mb-0 text-white-75 small">{{ $materia->nombre }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 bg-light bg-opacity-40">
                    <div class="mb-4 bg-white p-3 rounded-3 border shadow-3xs d-flex align-items-center">
                        <i class="fas fa-user-graduate text-primary-custom me-3 fa-lg"></i>
                        <div>
                            <span class="text-muted font-size-2xs fw-bold text-uppercase d-block">Postulante</span>
                            <span class="fw-bold text-dark font-size-sm">{{ $postulante->nombres }} {{ $postulante->apellidos }}</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('evaluaciones.update', [$postulante, $materia]) }}">
                        @csrf @method('PUT')
                        
                        <div class="row g-3">
                            @foreach(['examen1' => 'Examen Parcial 1', 'examen2' => 'Examen Parcial 2', 'examen3' => 'Examen Final'] as $field => $label)
                            <div class="col-12">
                                <label class="form-label font-size-xs fw-semibold text-dark">{{ $label }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-sort-numeric-down text-secondary"></i></span>
                                    <input type="number" step="0.01" min="0" max="100" name="{{ $field }}" 
                                           class="form-control font-size-sm border-start-0" 
                                           value="{{ $evaluacion->$field }}" placeholder="0.00">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-4 mt-4 border-top d-flex gap-2 justify-content-end">
                            <a href="{{ route('evaluaciones.index', $postulante) }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">Cancelar</a>
                            <button type="submit" class="btn btn-primary-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up">
                                <i class="fas fa-check-circle me-1.5 font-size-xs"></i> Guardar Calificaciones
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@push('styles')
<style>
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .btn-primary-custom { background-color: #0a2b5e; color: white; border: none; }
    .btn-primary-custom:hover { background-color: #143e80; color: white; }
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .text-primary-custom { color: #0a2b5e; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
</style>
@endpush

@push('scripts')
<script>
    // Validar rangos en tiempo real para evitar errores de carga
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function() {
            if (parseFloat(this.value) > 100) this.value = 100;
            if (parseFloat(this.value) < 0) this.value = 0;
        });
    });
</script>
@endpush
@endsection