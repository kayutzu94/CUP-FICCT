@extends('layouts.app')

@section('title', 'Registrar Docente')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                    <i class="fas fa-user-plus fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Registrar Nuevo Docente</h4>
                    <p class="mb-0 text-white-50 small mt-1">Formulario de alta para personal de cátedra, perfiles académicos y validación de requisitos de contratación</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <form method="POST" action="{{ route('docentes.store') }}">
                @csrf
                
                <div class="mb-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-id-card text-secondary me-1"></i> Datos de Identificación y Contacto
                    </span>
                    
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Cédula de Identidad (CI) <span class="text-danger">*</span></label>
                            <input type="text" name="ci" class="form-control font-size-sm @error('ci') is-invalid @enderror" value="{{ old('ci') }}" placeholder="Ej. 1234567" required>
                            @error('ci')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="nombres" class="form-control font-size-sm @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" placeholder="Ej. Juan Carlos" required>
                            @error('nombres')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" class="form-control font-size-sm @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" placeholder="Ej. Pérez Mendoza" required>
                            @error('apellidos')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Dirección de Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control font-size-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Ej. docente@universidad.edu.bo" required>
                            @error('email')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Número de Teléfono / Celular <span class="text-danger">*</span></label>
                            <input type="text" name="telefono" class="form-control font-size-sm @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" placeholder="Ej. 70012345" required>
                            @error('telefono')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="my-4 opacity-50">
                
                <div class="mb-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-graduation-cap text-secondary me-1"></i> Perfil Profesional y Especialidades
                    </span>
                    
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Profesión Base <span class="text-danger">*</span></label>
                            <input type="text" name="profesion" class="form-control font-size-sm @error('profesion') is-invalid @enderror" value="{{ old('profesion') }}" placeholder="Ej. Ingeniero de Sistemas" required>
                            @error('profesion')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Área de Especialidad <span class="text-danger">*</span></label>
                            <input type="text" name="especialidad" class="form-control font-size-sm @error('especialidad') is-invalid @enderror" value="{{ old('especialidad') }}" placeholder="Ej. Base de Datos / Inteligencia Artificial" required>
                            @error('especialidad')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mt-3.5">
                            <div class="form-check custom-checkbox-card p-3 rounded-3 border bg-white shadow-3xs transition-all">
                                <input type="checkbox" name="tiene_maestria" value="1" class="form-check-input ms-0 me-2.5" id="maestria" {{ old('tiene_maestria') ? 'checked' : '' }}>
                                <label class="form-check-label font-size-sm fw-medium text-dark cursor-pointer select-none" for="maestria">
                                    <strong class="d-block font-size-sm text-primary-custom mb-0.5">Posee Grado de Maestría</strong>
                                    <span class="text-muted font-size-3xs d-block">Certificación de postgrado verificada en el sistema de títulos nacional.</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 mt-3.5">
                            <div class="form-check custom-checkbox-card p-3 rounded-3 border bg-white shadow-3xs transition-all">
                                <input type="checkbox" name="tiene_diplomado_educacion" value="1" class="form-check-input ms-0 me-2.5" id="diplomado" {{ old('tiene_diplomado_educacion') ? 'checked' : '' }}>
                                <label class="form-check-label font-size-sm fw-medium text-dark cursor-pointer select-none" for="diplomado">
                                    <strong class="d-block font-size-sm text-primary-custom mb-0.5">Diplomado en Educación Superior</strong>
                                    <span class="text-muted font-size-3xs d-block">Habilitación pedagógica obligatoria para el ejercicio docente universitario.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom my-4 p-3.5 shadow-3xs">
                    <div class="d-flex align-items-start">
                        <div class="indicator-circle-bg bg-white bg-opacity-60 text-primary-custom p-2 me-2.5 mt-0.5" style="width: 32px; height: 32px; font-size: 0.95rem;">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <div class="small">
                            <strong class="text-dark font-size-sm d-block">Reglamento Específico de Contratación Docente:</strong>
                            <p class="text-secondary mb-0 mt-0.5 font-size-xs">
                                Para la validación efectiva del registro, el perfil postulado debe cumplir mandatoriamente de forma simultánea con ambos requisitos de postgrado: <strong class="text-dark">Maestría</strong> y el <strong class="text-dark">Diplomado en Educación Superior</strong>. El incumplimiento bloqueará las cargas horarias en los reportes del CUP.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-3 border-top d-flex flex-wrap gap-2 justify-content-end">
                    <a href="{{ route('docentes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up w-100 w-sm-auto text-center">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto text-center">
                        <i class="fas fa-save me-1.5 font-size-xs"></i>Registrar Docente
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras generales institucionales */
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-primary-custom {
        background-color: #0a2b5e;
        color: white;
        border: none;
    }
    .btn-primary-custom:hover {
        background-color: #143e80;
        color: white;
    }
    
    .btn-white {
        background-color: #ffffff;
        color: #6c757d;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        color: #495057;
    }

    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .indicator-circle-bg {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Tarjetas personalizadas para los Checkboxes */
    .custom-checkbox-card {
        transition: all 0.2s ease-in-out;
    }
    .custom-checkbox-card:hover {
        border-color: rgba(10, 43, 94, 0.25) !important;
        background-color: rgba(10, 43, 94, 0.01) !important;
    }
    .custom-checkbox-card .form-check-input {
        float: left;
        margin-top: 0.25rem;
        cursor: pointer;
        width: 1.15rem;
        height: 1.15rem;
    }
    .custom-checkbox-card .form-check-input:checked {
        background-color: #0a2b5e;
        border-color: #0a2b5e;
    }

    /* Clases utilitarias adaptativas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .me-2.5 { margin-right: 0.65rem; }
    .mt-3.5 { margin-top: 0.85rem !important; }
    .p-3.5 { padding: 1.1rem !important; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .font-size-3xs { font-size: 0.66rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
    .tracking-wider { letter-spacing: 0.05em; }
    .cursor-pointer { cursor: pointer; }

    /* Entradas del Formulario Enfocadas */
    .form-control:focus {
        border-color: rgba(10, 43, 94, 0.4);
        box-shadow: 0 0 0 0.2rem rgba(10, 43, 94, 0.12);
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush