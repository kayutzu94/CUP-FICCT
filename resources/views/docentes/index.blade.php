@extends('layouts.app')

@section('title', 'Lista de Docentes')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Lista de Docentes</h4>
        <a href="{{ route('docentes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Docente
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>CI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Profesión</th>
                        <th>Especialidad</th>
                        <th>Requisitos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $docente)
                    <tr>
                        <td>{{ $docente->ci }}</td>
                        <td>{{ $docente->nombres }}</td>
                        <td>{{ $docente->apellidos }}</td>
                        <td>{{ $docente->email }}</td>
                        <td>{{ $docente->profesion }}</td>
                        <td>{{ $docente->especialidad }}</td>
                        <td>
                            @if($docente->tiene_maestria && $docente->tiene_diplomado_educacion)
                                <span class="badge bg-success">Cumple requisitos</span>
                            @else
                                <span class="badge bg-danger">No cumple</span>
                            @endif
                        </td>
                        <td>
                            @if($docente->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#asignarModal{{ $docente->id }}">
                                    <i class="fas fa-users"></i> Asignar
                                </button>
                                <form action="{{ route('docentes.destroy', $docente) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $docente->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Modal Asignar a Grupos -->
                            <div class="modal fade" id="asignarModal{{ $docente->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Asignar Docente a Grupos</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('docentes.asignar-grupos', $docente) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p><strong>Docente:</strong> {{ $docente->nombre_completo }}</p>
                                                <div class="mb-3">
                                                    <label>Seleccionar Materia</label>
                                                    <select name="materia_id" class="form-control" required>
                                                        <option value="">Seleccione...</option>
                                                        @foreach(\App\Models\Materia::all() as $materia)
                                                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Seleccionar Grupos (mínimo 1, máximo 4)</label>
                                                    <select name="grupos[]" class="form-control" multiple required>
                                                        @foreach(\App\Models\Grupo::all() as $grupo)
                                                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }} ({{ $grupo->estudiantes_actuales }}/{{ $grupo->capacidad_maxima }})</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">Presiona Ctrl para seleccionar múltiples grupos</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Asignar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay docentes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $docentes->links() }}
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(formId) {
        if(confirm('¿Está seguro de eliminar este docente?')) {
            document.getElementById(formId).submit();
        }
    }
</script>
@endpush
@endsection