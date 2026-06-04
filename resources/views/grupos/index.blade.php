@extends('layouts.app')
@section('title', 'Grupos')
@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Inscritos</h5>
                <h2>{{ $totalInscritos }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Grupos Necesarios</h5>
                <h2>{{ $gruposNecesarios }}</h2>
                <small>Fórmula: CEIL({{ $totalInscritos }}/70)</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Grupos Creados</h5>
                <h2>{{ $grupos->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Gestión de Grupos</h4>
        <div>
            <form action="{{ route('grupos.asignar-automatico') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('¿Asignar automáticamente todos los estudiantes?')">
                    <i class="fas fa-magic"></i> Asignar Automáticamente
                </button>
            </form>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearGrupoModal">
                <i class="fas fa-plus"></i> Crear Grupo
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($grupos as $grupo)
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">{{ $grupo->nombre }}</h5>
                        <small>{{ $grupo->codigo }}</small>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-2">
                            <div class="progress-bar" role="progressbar" style="width: {{ ($grupo->estudiantes_actuales / $grupo->capacidad_maxima) * 100 }}%">
                                {{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }}
                            </div>
                        </div>
                        <p><i class="fas fa-users"></i> Estudiantes: {{ $grupo->estudiantes_actuales }}</p>
                        <a href="{{ route('grupos.show', $grupo) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Ver Estudiantes
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Crear Grupo -->
<div class="modal fade" id="crearGrupoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Crear Nuevo Grupo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('grupos.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Código</label>
                        <input type="text" name="codigo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="alert alert-info">Capacidad máxima: 70 estudiantes</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection