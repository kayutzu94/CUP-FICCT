@extends('layouts.app')

@section('title', 'Registrar Docente')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Registrar Nuevo Docente</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('docentes.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>CI <span class="text-danger">*</span></label>
                    <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci') }}" required>
                    @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Nombres <span class="text-danger">*</span></label>
                    <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" required>
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Teléfono <span class="text-danger">*</span></label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                    @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Profesión <span class="text-danger">*</span></label>
                    <input type="text" name="profesion" class="form-control @error('profesion') is-invalid @enderror" value="{{ old('profesion') }}" required>
                    @error('profesion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Especialidad <span class="text-danger">*</span></label>
                    <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad') }}" required>
                    @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="tiene_maestria" value="1" class="form-check-input" id="maestria">
                        <label class="form-check-label" for="maestria">Tiene Maestría</label>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="tiene_diplomado_educacion" value="1" class="form-check-input" id="diplomado">
                        <label class="form-check-label" for="diplomado">Tiene Diplomado en Educación Superior</label>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info">
                <strong>Requisitos para contratación:</strong> El docente debe tener Maestría Y Diplomado en Educación Superior.
            </div>
            
            <div class="text-end">
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Docente</button>
            </div>
        </form>
    </div>
</div>
@endsection