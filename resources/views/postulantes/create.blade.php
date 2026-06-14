@extends('layouts.app')

@section('title', 'Registrar Postulante')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                    <i class="fas fa-user-plus fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Admisión de Nuevo Postulante</h4>
                    <p class="mb-0 text-white-50 small mt-1">Proceso de registro formal y validación de requisitos de inscripción universitaria</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if(!session('pago_completado'))
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom mb-4 p-3.5 shadow-3xs d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                        <div>
                            <strong class="d-block font-size-sm">Pago de Inscripción Pendiente</strong>
                            <small>Debe completar el arancel de $100.00 USD para habilitar el formulario de registro.</small>
                        </div>
                    </div>
                    <a href="{{ route('paypal.create') }}" class="btn btn-primary-custom shadow-sm px-4">
                        <i class="fab fa-paypal me-1.5"></i> Pagar con PayPal
                    </a>
                </div>
            @else
                <div class="alert alert-success border-0 rounded-3 bg-success bg-opacity-10 text-success mb-4 p-3 shadow-3xs">
                    <i class="fas fa-check-circle me-1.5"></i> <strong>Pago verificado:</strong> El arancel ha sido recibido correctamente.
                </div>
            @endif

            <form method="POST" action="{{ route('postulantes.store') }}">
                @csrf
                
                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-user text-secondary me-1"></i> Información del Postulante
                </span>
                
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">CI <span class="text-danger">*</span></label>
                        <input type="text" name="ci" class="form-control font-size-sm @error('ci') is-invalid @enderror" value="{{ old('ci') }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Nombres <span class="text-danger">*</span></label>
                        <input type="text" name="nombres" class="form-control font-size-sm @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" class="form-control font-size-sm @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control font-size-sm" value="{{ old('fecha_nacimiento') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Sexo</label>
                        <select name="sexo" class="form-select font-size-sm">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Teléfono</label>
                        <input type="text" name="telefono" class="form-control font-size-sm" value="{{ old('telefono') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control font-size-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-graduation-cap text-secondary me-1"></i> Antecedentes y Preferencias Académicas
                </span>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Ciudad de Procedencia</label>
                        <input type="text" name="ciudad" class="form-control font-size-sm" value="{{ old('ciudad') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Unidad Educativa</label>
                        <input type="text" name="colegio" class="form-control font-size-sm" value="{{ old('colegio') }}">
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Título de Bachiller <span class="text-danger">*</span></label>
                        <input type="text" name="titulo_bachiller" class="form-control font-size-sm" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Primera Carrera <span class="text-danger">*</span></label>
                        <select name="primera_carrera_id" class="form-select font-size-sm" required>
                            <option value="">Seleccione una carrera...</option>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }} ({{ ($c->cupo - $c->inscritos_actuales) }} cupos)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Segunda Carrera <span class="text-danger">*</span></label>
                        <select name="segunda_carrera_id" class="form-select font-size-sm" required>
                            <option value="">Seleccione una alternativa...</option>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label font-size-xs fw-semibold text-dark">Observaciones adicionales</label>
                        <textarea name="otros" class="form-control font-size-sm" rows="2">{{ old('otros') }}</textarea>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('postulantes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">Cancelar</a>
                    <button type="submit" class="btn btn-primary-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up">
                        <i class="fas fa-save me-1.5 font-size-xs"></i> Confirmar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .metric-icon-box { width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .btn-primary-custom { background-color: #0a2b5e; color: white; border: none; }
    .btn-primary-custom:hover { background-color: #143e80; color: white; }
    .btn-white { background-color: #ffffff; color: #6c757d; }
    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
    .hover-up { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-up:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
</style>
@endpush