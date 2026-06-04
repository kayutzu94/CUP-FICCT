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
                <input type="text" name="search" class="form-control" placeholder="Buscar por CI, nombres, apellidos o email...">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
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
                    @foreach($postulantes as $p)
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
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $postulantes->links() }}
    </div>
</div>
@endsection