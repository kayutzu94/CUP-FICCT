@extends('layouts.app')

@section('title', 'Editar Postulante')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-white">
        <h4><i class="fas fa-edit"></i> Editar Postulante</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('postulantes.update', $postulante) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>CI <span class="text-danger">*</span></label>
                    <input type="text" name="ci" class="form-control @error('ci') is-invalid @enderror" value="{{ old('ci', $postulante->ci) }}" required>
                    @error('ci')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Nombres <span class="text-danger">*</span></label>
                    <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $postulante->nombres) }}" required>
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $postulante->apellidos) }}" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $postulante->fecha_nacimiento) }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="M" {{ $postulante->sexo == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ $postulante->sexo == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $postulante->telefono) }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $postulante->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $postulante->direccion) }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $postulante->ciudad) }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Colegio</label>
                    <input type="text" name="colegio" class="form-control" value="{{ old('colegio', $postulante->colegio) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Título Bachiller</label>
                    <input type="text" name="titulo_bachiller" class="form-control" value="{{ old('titulo_bachiller', $postulante->titulo_bachiller) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Primera Carrera <span class="text-danger">*</span></label>
                    <select name="primera_carrera_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id }}" {{ $postulante->primera_carrera_id == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }} (Cupos: {{ $c->cupo - $c->inscritos_actuales }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Segunda Carrera <span class="text-danger">*</span></label>
                    <select name="segunda_carrera_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id }}" {{ $postulante->segunda_carrera_id == $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label>Otros</label>
                    <textarea name="otros" class="form-control" rows="2">{{ old('otros', $postulante->otros) }}</textarea>
                </div>
            </div>
            
            <div class="alert alert-info">
                <strong>Nota:</strong> Si cambia la carrera, el sistema intentará reasignar según cupos disponibles.
            </div>
            
            <div class="text-end">
                <a href="{{ route('postulantes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Postulante</button>
            </div>
        </form>
    </div>
</div>
@endsection