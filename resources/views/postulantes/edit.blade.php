@extends('layouts.app')

@section('title', 'Editar Postulante')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #b78a02 0%, #e0a800 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-warning-custom shadow-2xs">
                    <i class="fas fa-user-edit fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Editar Perfil del Postulante</h4>
                    <p class="mb-0 text-white-75 small mt-1">Actualización de datos personales y preferencias de carrera universitaria</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <form method="POST" action="{{ route('postulantes.update', $postulante) }}">
                @csrf
                @method('PUT')
                
                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-user text-secondary me-1"></i> Datos de Filiación
                </span>
                
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">CI <span class="text-danger">*</span></label>
                        <input type="text" name="ci" class="form-control font-size-sm @error('ci') is-invalid @enderror" value="{{ old('ci', $postulante->ci) }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Nombres <span class="text-danger">*</span></label>
                        <input type="text" name="nombres" class="form-control font-size-sm @error('nombres') is-invalid @enderror" value="{{ old('nombres', $postulante->nombres) }}" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label font-size-xs fw-semibold text-dark">Apellidos <span class="text-danger">*</span></label>
                        <input type="text" name="apellidos" class="form-control font-size-sm @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $postulante->apellidos) }}" required>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Fecha Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control font-size-sm" value="{{ old('fecha_nacimiento', $postulante->fecha_nacimiento) }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Sexo</label>
                        <select name="sexo" class="form-select font-size-sm">
                            <option value="M" {{ $postulante->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $postulante->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Teléfono</label>
                        <input type="text" name="telefono" class="form-control font-size-sm" value="{{ old('telefono', $postulante->telefono) }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control font-size-sm @error('email') is-invalid @enderror" value="{{ old('email', $postulante->email) }}" required>
                    </div>
                </div>

                <hr class="opacity-50 my-4">

                <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                    <i class="fas fa-graduation-cap text-secondary me-1"></i> Información Académica
                </span>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Dirección</label>
                        <input type="text" name="direccion" class="form-control font-size-sm" value="{{ old('direccion', $postulante->direccion) }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Ciudad</label>
                        <input type="text" name="ciudad" class="form-control font-size-sm" value="{{ old('ciudad', $postulante->ciudad) }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label font-size-xs fw-semibold text-dark">Colegio</label>
                        <input type="text" name="colegio" class="form-control font-size-sm" value="{{ old('colegio', $postulante->colegio) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label font-size-xs fw-semibold text-dark">Título de Bachiller</label>
                        <input type="text" name="titulo_bachiller" class="form-control font-size-sm" value="{{ old('titulo_bachiller', $postulante->titulo_bachiller) }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Primera Carrera <span class="text-danger">*</span></label>
                        <select name="primera_carrera_id" class="form-select font-size-sm" required>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}" {{ $postulante->primera_carrera_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }} (Cupos: {{ $c->cupo - $c->inscritos_actuales }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label font-size-xs fw-semibold text-dark">Segunda Carrera <span class="text-danger">*</span></label>
                        <select name="segunda_carrera_id" class="form-select font-size-sm" required>
                            @foreach($carreras as $c)
                                <option value="{{ $c->id }}" {{ $postulante->segunda_carrera_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label font-size-xs fw-semibold text-dark">Otros</label>
                        <textarea name="otros" class="form-control font-size-sm" rows="2">{{ old('otros', $postulante->otros) }}</textarea>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom my-4 p-3 shadow-3xs d-flex align-items-center">
                    <i class="fas fa-info-circle me-3 fa-lg"></i>
                    <span class="font-size-sm"><strong>Nota:</strong> Al modificar la carrera, el sistema reevaluará automáticamente la asignación basándose en los cupos disponibles.</span>
                </div>

                <div class="pt-3 mt-4 border-top d-flex gap-2 justify-content-end">
                    <a href="{{ route('postulantes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up">Cancelar</a>
                    <button type="submit" class="btn btn-warning-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm hover-up text-white">
                        <i class="fas fa-save me-1.5 font-size-xs"></i> Guardar Cambios
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
    .btn-warning-custom { background-color: #e0a800; border: none; }
    .btn-warning-custom:hover { background-color: #c69500; }
    .text-warning-custom { color: #b78a02 !important; }
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