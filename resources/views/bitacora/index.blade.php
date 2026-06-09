@extends('layouts.app')

@section('title', 'Bitácora del Sistema')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-history"></i> Bitácora del Sistema</h4>
        <form action="{{ route('bitacora.limpiar') }}" method="POST" onsubmit="return confirm('¿Está seguro de limpiar toda la bitácora? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Limpiar Bitácora
            </button>
        </form>
    </div>
    <div class="card-body">
        @if($registros->isEmpty())
            <div class="alert alert-info text-center py-4">
                <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                <h5>No hay registros en la bitácora</h5>
                <p>Las acciones de los usuarios se registrarán automáticamente aquí.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Tabla</th>
                            <th>Registro ID</th>
                            <th>Detalles</th>
                            <th>IP</th>
                            <th>Fecha/Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->usuario }}</td>
                            <td>{{ $r->accion }}</td>
                            <td>{{ $r->tabla_afectada ?? '-' }}</td>
                            <td>{{ $r->registro_id ?? '-' }}</td>
                            <td>{{ $r->detalles ?? '-' }}</td>
                            <td>{{ $r->ip ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($registros->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Mostrando {{ $registros->firstItem() }} a {{ $registros->lastItem() }} de {{ $registros->total() }} registros
                        </small>
                    </div>
                    <div>
                        @if ($registros->onFirstPage())
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-chevron-left"></i> Anterior
                            </button>
                        @else
                            <a href="{{ $registros->previousPageUrl() }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-chevron-left"></i> Anterior
                            </a>
                        @endif
                        
                        @if ($registros->hasMorePages())
                            <a href="{{ $registros->nextPageUrl() }}" class="btn btn-primary btn-sm">
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
        @endif
    </div>
</div>
@endsection