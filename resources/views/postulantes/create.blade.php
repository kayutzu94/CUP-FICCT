@extends('layouts.app')
@section('title', 'Registrar Postulante')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-user-plus"></i> Registrar Nuevo Postulante</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('postulantes.store') }}">
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
                <div class="col-md-3 mb-3">
                    <label>Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Colegio</label>
                    <input type="text" name="colegio" class="form-control" value="{{ old('colegio') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Título Bachiller</label>
                    <input type="text" name="titulo_bachiller" class="form-control" value="{{ old('titulo_bachiller') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Primera Carrera <span class="text-danger">*</span></label>
                    <select name="primera_carrera_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }} (Cupos disponibles: {{ $c->cupo - $c->inscritos_actuales }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Segunda Carrera <span class="text-danger">*</span></label>
                    <select name="segunda_carrera_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Otros</label>
                    <textarea name="otros" class="form-control" rows="2">{{ old('otros') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
            <a href="{{ route('postulantes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection