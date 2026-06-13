@extends('layouts.app')

@section('title', 'Editar Docente')

@section('content')
<div class="card shadow">
    <div class="card-header bg-warning text-white py-3">
        <h4 class="m-0"><i class="fas fa-user-edit"></i> Editar Docente</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('docentes.update', $docente) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">CI <span class="text-danger">*</span></label>
                    <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci', $docente->ci) }}" required>
                    @error('ci')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Nombres <span class="text-danger">*</span></label>
                    <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $docente->nombres) }}" required>
                    @error('nombres')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $docente->apellidos) }}" required>
                    @error('apellidos')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $docente->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Teléfono <span class="text-danger">*</span></label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $docente->telefono) }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Profesión <span class="text-danger">*</span></label>
                    <input type="text" name="profesion" class="form-control @error('profesion') is-invalid @enderror" value="{{ old('profesion', $docente->profesion) }}" required>
                    @error('profesion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Especialidad <span class="text-danger">*</span></label>
                    <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad', $docente->especialidad) }}" required>
                    @error('especialidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            <h5 class="mb-3 text-primary"><i class="fas fa-tasks"></i> Requisitos Académicos y de Estado</h5>
            
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch p-3 bg-light rounded border">
                        <input type="hidden" name="tiene_maestria" value="0">
                        <input type="checkbox" name="tiene_maestria" value="1" class="form-check-input ms-0 me-2" id="maestria" {{ old('tiene_maestria', $docente->tiene_maestria) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="maestria">Tiene Maestría</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch p-3 bg-light rounded border">
                        <input type="hidden" name="tiene_diplomado_educacion" value="0">
                        <input type="checkbox" name="tiene_diplomado_educacion" value="1" class="form-check-input ms-0 me-2" id="diplomado" {{ old('tiene_diplomado_educacion', $docente->tiene_diplomado_educacion) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="diplomado">Tiene Diplomado Educación</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch p-3 bg-light rounded border">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1" class="form-check-input ms-0 me-2" id="activo" {{ old('activo', $docente->activo) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-success" for="activo">Docente Activo</label>
                    </div>
                </div>
            </div>

            <div class="alert alert-info mb-4" style="border-left: 4px solid #0dcaf0;">
                <i class="fas fa-info-circle text-info"></i> 
                <strong>📌 Nota de Habilitación:</strong> Para que un docente pueda ser asignado a grupos en el sistema, debe contar con <strong>Maestría, Diplomado en Educación Superior y estar Activo</strong>.
            </div>

            <div class="text-end gap-2">
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Actualizar Docente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection