@extends('layouts.app')

@section('title', 'Editar Docente')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #b78a02 0%, #e0a800 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-warning-custom shadow-2xs">
                    <i class="fas fa-user-edit fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Modificar Perfil de Docente</h4>
                    <p class="mb-0 text-white-50 small mt-1">Actualización de datos generales, estado operativo de cátedra y acreditaciones académicas del titular</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <form method="POST" action="{{ route('docentes.update', $docente) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-id-card text-secondary me-1"></i> Datos de Identificación y Contacto
                    </span>
                    
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Cédula de Identidad (CI) <span class="text-danger">*</span></label>
                            <input type="text" name="ci" class="form-control font-size-sm @error('ci') is-invalid @enderror" value="{{ old('ci', $docente->ci) }}" required>
                            @error('ci')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="nombres" class="form-control font-size-sm @error('nombres') is-invalid @enderror" value="{{ old('nombres', $docente->nombres) }}" required>
                            @error('nombres')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label font-size-xs fw-semibold text-dark">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" class="form-control font-size-sm @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $docente->apellidos) }}" required>
                            @error('apellidos')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Dirección de Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control font-size-sm @error('email') is-invalid @enderror" value="{{ old('email', $docente->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Número de Teléfono / Celular <span class="text-danger">*</span></label>
                            <input type="text" name="telefono" class="form-control font-size-sm @error('telefono') is-invalid @enderror" value="{{ old('telefono', $docente->telefono) }}" required>
                            @error('telefono')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Profesión Base <span class="text-danger">*</span></label>
                            <input type="text" name="profesion" class="form-control font-size-sm @error('profesion') is-invalid @enderror" value="{{ old('profesion', $docente->profesion) }}" required>
                            @error('profesion')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label font-size-xs fw-semibold text-dark">Área de Especialidad <span class="text-danger">*</span></label>
                            <input type="text" name="especialidad" class="form-control font-size-sm @error('especialidad') is-invalid @enderror" value="{{ old('especialidad', $docente->especialidad) }}" required>
                            @error('especialidad')
                                <div class="invalid-feedback font-size-2xs fw-medium">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="my-4 opacity-50">
                
                <div class="mb-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-tasks text-secondary me-1"></i> Requisitos Académicos y de Estado Operativo
                    </span>
                    
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="form-check form-switch custom-checkbox-card p-3 rounded-3 border bg-white shadow-3xs transition-all d-flex align-items-center justify-content-between">
                                <label class="form-check-label font-size-sm fw-semibold text-dark cursor-pointer select-none mb-0" for="maestria">
                                    <span class="text-primary-custom d-block">Tiene Maestría</span>
                                    <span class="text-muted font-size-3xs fw-normal d-block mt-0.5">Acreditación de postgrado</span>
                                </label>
                                <div class="switch-wrapper me-1">
                                    <input type="hidden" name="tiene_maestria" value="0">
                                    <input type="checkbox" name="tiene_maestria" value="1" class="form-check-input" id="maestria" {{ old('tiene_maestria', $docente->tiene_maestria) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-check form-switch custom-checkbox-card p-3 rounded-3 border bg-white shadow-3xs transition-all d-flex align-items-center justify-content-between">
                                <label class="form-check-label font-size-sm fw-semibold text-dark cursor-pointer select-none mb-0" for="diplomado">
                                    <span class="text-primary-custom d-block">Diplomado Educación</span>
                                    <span class="text-muted font-size-3xs fw-normal d-block mt-0.5">Habilitación pedagógica superior</span>
                                </label>
                                <div class="switch-wrapper me-1">
                                    <input type="hidden" name="tiene_diplomado_educacion" value="0">
                                    <input type="checkbox" name="tiene_diplomado_educacion" value="1" class="form-check-input" id="diplomado" {{ old('tiene_diplomado_educacion', $docente->tiene_diplomado_educacion) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-check form-switch custom-checkbox-card p-3 rounded-3 border bg-white shadow-3xs transition-all d-flex align-items-center justify-content-between border-success-subtle">
                                <label class="form-check-label font-size-sm fw-semibold text-dark cursor-pointer select-none mb-0" for="activo">
                                    <span class="text-success d-block fw-bold">Docente Activo</span>
                                    <span class="text-muted font-size-3xs fw-normal d-block mt-0.5">Permite asignación en aulas</span>
                                </label>
                                <div class="switch-wrapper me-1">
                                    <input type="hidden" name="activo" value="0">
                                    <input type="checkbox" name="activo" value="1" class="form-check-input bg-success-input" id="activo" {{ old('activo', $docente->activo) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom my-4 p-3.5 shadow-3xs">
                    <div class="d-flex align-items-start">
                        <div class="indicator-circle-bg bg-white bg-opacity-60 text-primary-custom p-2 me-2.5 mt-0.5" style="width: 32px; height: 32px; font-size: 0.95rem;">
                            <i class="fas fa-info-circle text-info"></i>
                        </div>
                        <div class="small">
                            <strong class="text-dark font-size-sm d-block">📌 Nota de Habilitación de Cátedra:</strong>
                            <p class="text-secondary mb-0 mt-0.5 font-size-xs">
                                Para asegurar la integridad operacional del sistema académico, un docente únicamente podrá ser vinculado y asignado a grupos activos si cumple concurrentemente con: <strong class="text-dark">Maestría</strong>, <strong class="text-dark">Diplomado en Educación Superior</strong> y mantener el estado de <strong class="text-success">Docente Activo</strong>.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-3 border-top d-flex flex-wrap gap-2 justify-content-end">
                    <a href="{{ route('docentes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up w-100 w-sm-auto text-center">
                        <i class="fas fa-times me-1.5 font-size-xs"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up w-100 w-sm-auto text-center">
                        <i class="fas fa-save me-1.5 font-size-xs"></i> Actualizar Docente
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
    .text-warning-custom { color: #b78a02 !important; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }

    .indicator-circle-bg {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Ajustes sutiles para los Cards que contienen los switches */
    .custom-checkbox-card {
        transition: all 0.2s ease-in-out;
    }
    .custom-checkbox-card:hover {
        border-color: rgba(10, 43, 94, 0.25) !important;
        background-color: rgba(10, 43, 94, 0.01) !important;
    }
    .border-success-subtle:hover {
        border-color: rgba(40, 167, 69, 0.4) !important;
        background-color: rgba(40, 167, 69, 0.01) !important;
    }

    /* Corrección de padding e interacción nativa del Bootstrap Switch dentro del Flex */
    .custom-checkbox-card.form-switch {
        padding-left: 1rem !important;
    }
    .switch-wrapper .form-check-input {
        margin-left: 0 !important;
        cursor: pointer;
        width: 2.25rem;
        height: 1.22rem;
    }
    .switch-wrapper .form-check-input:checked {
        background-color: #0a2b5e;
        border-color: #0a2b5e;
    }
    .switch-wrapper .form-check-input.bg-success-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    /* Clases utilitarias adaptativas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .me-2.5 { margin-right: 0.65rem; }
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