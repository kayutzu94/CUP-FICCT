@extends('layouts.app')

@section('title', 'Detalles del Docente')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fas fa-chalkboard-user"></i> Detalles del Docente</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40%;">CI</th>
                        <td>{{ $docente->ci }}</td>
                    </tr>
                    <tr>
                        <th>Nombres</th>
                        <td>{{ $docente->nombres }}</td>
                    </tr>
                    <tr>
                        <th>Apellidos</th>
                        <td>{{ $docente->apellidos }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $docente->email }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $docente->telefono }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40%;">Profesión</th>
                        <td>{{ $docente->profesion }}</td>
                    </tr>
                    <tr>
                        <th>Especialidad</th>
                        <td>{{ $docente->especialidad }}</td>
                    </tr>
                    <tr>
                        <th>Maestría</th>
                        <td>
                            @if($docente->tiene_maestria)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Diplomado Educación Superior</th>
                        <td>
                            @if($docente->tiene_diplomado_educacion)
                                <span class="badge bg-success">Sí</span>
                            @else
                                <span class="badge bg-danger">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($docente->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        @if($docente->asignaciones->count() > 0)
            <h5 class="mt-4">Grupos Asignados</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Grupo</th>
                            <th>Materia</th>
                            <th>Fecha Asignación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docente->asignaciones as $asignacion)
                        <tr>
                            <td>{{ $asignacion->grupo->nombre ?? 'N/A' }} ({{ $asignacion->grupo->codigo ?? '' }})</td>
                            <td>{{ $asignacion->materia->nombre ?? 'N/A' }}</td>
                            <td>{{ $asignacion->fecha_asignacion->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="text-end mt-3">
            <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>
@endsection