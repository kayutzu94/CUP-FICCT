@extends('layouts.app')
@section('title', 'Lista de Postulantes')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Lista de Postulantes</h4>
        <a href="{{ route('postulantes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Postulante</a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('postulantes.search') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por CI, nombres, apellidos o email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                @if(request('search'))
                    <a href="{{ route('postulantes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>CI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>1ra Carrera</th>
                        <th>2da Carrera</th>
                        <th>Carrera Asignada</th>
                        <th>Estado</th>
                        <th>Promedio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($postulantes as $p)
                    <tr>
                        <td>{{ $p->ci }}</td>
                        <td>{{ $p->nombres }}</td>
                        <td>{{ $p->apellidos }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->primeraCarrera->nombre ?? 'N/A' }}</td>
                        <td>{{ $p->segundaCarrera->nombre ?? 'N/A' }}</td>
                        <td>{{ $p->carreraAsignada->nombre ?? 'Pendiente' }}</td>
                        <td>
                            @if($p->estado_academico == 'aprobado')
                                <span class="badge bg-success">APROBADO</span>
                            @elseif($p->estado_academico == 'reprobado')
                                <span class="badge bg-danger">REPROBADO</span>
                            @else
                                <span class="badge bg-warning">INSCRITO</span>
                            @endif
                        </td>
                        <td>{{ number_format($p->promedio_final ?? 0, 2) }}</td>
                        <td>
                            <a href="{{ route('postulantes.show', $p) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('postulantes.edit', $p) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('evaluaciones.index', $p) }}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a>
                            <form id="delete-form-{{ $p->id }}" action="{{ route('postulantes.destroy', $p) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('delete-form-{{ $p->id }}')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                @if(request('search'))
                                    No se encontraron postulantes con "<strong>{{ request('search') }}</strong>"
                                @else
                                    No hay postulantes registrados
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- PAGINACIÓN AL FINAL DE LA PÁGINA -->
        <div class="mt-4">
            @if($postulantes->hasPages())
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">
                            Mostrando {{ $postulantes->firstItem() }} a {{ $postulantes->lastItem() }} de {{ $postulantes->total() }} resultados
                        </small>
                    </div>
                    <div>
                        @if ($postulantes->onFirstPage())
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-chevron-left"></i> Anterior
                            </button>
                        @else
                            <a href="{{ $postulantes->previousPageUrl() }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-chevron-left"></i> Anterior
                            </a>
                        @endif
                        
                        @if ($postulantes->hasMorePages())
                            <a href="{{ $postulantes->nextPageUrl() }}" class="btn btn-primary btn-sm">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection