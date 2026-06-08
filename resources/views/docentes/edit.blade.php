@extends('layouts.app')

@section('title', 'Editar Docente')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h4><i class="fas fa-edit"></i> Editar Docente</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('docentes.update', $docente) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">CI <span class="text-danger">*</span></label>
                    <input type="text" name="ci" class="form-control" value="{{ old('ci', $docente->ci) }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Nombres <span class="text-danger">*</span></label>
                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $docente->nombres) }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $docente->apellidos) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $docente->email) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $docente->telefono) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Profesión <span class="text-danger">*</span></label>
                    <input type="text" name="profesion" class="form-control" value="{{ old('profesion', $docente->profesion) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Especialidad <span class="text-danger">*</span></label>
                    <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $docente->especialidad) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="tiene_maestria" value="1" class="form-check-input" id="maestria" {{ $docente->tiene_maestria ? 'checked' : '' }}>
                        <label class="form-check-label" for="maestria">Tiene Maestría</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="tiene_diplomado_educacion" value="1" class="form-check-input" id="diplomado" {{ $docente->tiene_diplomado_educacion ? 'checked' : '' }}>
                        <label class="form-check-label" for="diplomado">Tiene Diplomado en Educación Superior</label>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <strong>📌 Nota:</strong> Para que un docente sea contratado, debe cumplir con <strong>Maestría Y Diplomado en Educación Superior</strong>.
            </div>

            <div class="text-end">
                <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Docente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection