@extends('layouts.app')

@section('title', 'Lista de Postulantes')

@section('content')
<div class="container-fluid px-0 py-2">
    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header border-0 py-3.5 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div>
                <h4 class="mb-0 fw-bold text-white d-flex align-items-center">
                    <i class="fas fa-users me-2 opacity-75"></i> Lista de Postulantes
                </h4>
                <p class="mb-0 text-white-50 small mt-1">Control de aspirantes registrados en el Sistema CUP</p>
            </div>
            <div>
                <a href="{{ route('postulantes.create') }}" class="btn btn-warning fw-bold text-dark rounded-3 px-3 shadow-sm hover-up">
                    <i class="fas fa-plus me-1"></i> Nuevo Postulante
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            
            <form method="GET" action="{{ route('postulantes.search') }}" class="mb-4">
                <div class="row g-2 justify-content-start align-items-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="input-group shadow-sm rounded-3 overflow-hidden border">
                            <span class="input-group-text bg-white border-0 text-muted px-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0 py-2.5 ps-1 font-size-sm" placeholder="Buscar por CI, nombres, apellidos o email..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-action px-4 fw-medium">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('postulantes.index') }}" class="btn btn-secondary d-flex align-items-center px-3 border-0" style="background-color: #6c757d;">
                                    <i class="fas fa-times me-1"></i> Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="custom-table-header text-white">
                        <tr>
                            <th class="py-3 px-3">CI</th>
                            <th class="py-3">Nombres</th>
                            <th class="py-3">Apellidos</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">1ra Carrera</th>
                            <th class="py-3">2da Carrera</th>
                            <th class="py-3">Carrera Asignada</th>
                            <th class="py-3 text-center">Estado</th>
                            <th class="py-3 text-center">Promedio</th>
                            <th class="py-3 text-center px-3" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($postulantes as $p)
                        <tr class="row-hover-effect">
                            <td class="px-3 fw-bold text-dark font-monospace">{{ $p->ci }}</td>
                            <td>{{ $p->nombres }}</td>
                            <td>{{ $p->apellidos }}</td>
                            <td class="text-muted small">{{ $p->email }}</td>
                            <td><span class="badge bg-light text-dark border font-size-xs px-2 py-1.5">{{ $p->primeraCarrera->nombre ?? 'N/A' }}</span></td>
                            <td><span class="badge bg-light text-dark border font-size-xs px-2 py-1.5">{{ $p->segundaCarrera->nombre ?? 'N/A' }}</span></td>
                            <td>
                                @if($p->carreraAsignada)
                                    <span class="badge bg-primary-soft text-primary-custom px-2 py-1.5 font-size-xs border border-primary border-opacity-10 fw-semibold">
                                        <i class="fas fa-graduation-cap me-1"></i>{{ $p->carreraAsignada->nombre }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border px-2 py-1.5 font-size-xs italic">Pendiente</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->estado_academico == 'aprobado')
                                    <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill font-size-xs fw-bold">
                                        <i class="fas fa-check-circle me-1"></i>APROBADO
                                    </span>
                                @elseif($p->estado_academico == 'reprobado')
                                    <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill font-size-xs fw-bold">
                                        <i class="fas fa-times-circle me-1"></i>REPROBADO
                                    </span>
                                @else
                                    <span class="badge bg-warning-soft text-warning-custom px-3 py-2 rounded-pill font-size-xs fw-bold">
                                        <i class="fas fa-clock me-1"></i>INSCRITO
                                    </span>
                                @endif
                            </td>
                            <td class="text-center fw-bold text-dark font-monospace">{{ number_format($p->promedio_final ?? 0, 2) }}</td>
                            <td class="text-center px-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('postulantes.show', $p) }}" class="btn btn-sm btn-outline-primary border-0 rounded-3 action-icon-btn" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('postulantes.edit', $p) }}" class="btn btn-sm btn-outline-warning border-0 rounded-3 action-icon-btn" title="Editar Registro">
                                        <i class="fas fa-edit text-warning-custom"></i>
                                    </a>
                                    <a href="{{ route('evaluaciones.index', $p) }}" class="btn btn-sm btn-outline-info border-0 rounded-3 action-icon-btn" title="Evaluaciones">
                                        <i class="fas fa-clipboard-list"></i>
                                    </a>
                                    <form id="delete-form-{{ $p->id }}" action="{{ route('postulantes.destroy', $p) }}" method="POST" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-3 action-icon-btn" onclick="confirmDelete('delete-form-{{ $p->id }}')" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 bg-light bg-opacity-50">
                                <div class="py-3">
                                    <i class="fas fa-user-slash text-muted fa-3x mb-3 opacity-50"></i>
                                    @if(request('search'))
                                        <h5 class="text-muted fw-normal">No se encontraron postulantes coincidentes</h5>
                                        <p class="text-muted small mb-0">Ningún registro coincide con el término: "<strong>{{ request('search') }}</strong>"</p>
                                    @else
                                        <h5 class="text-muted fw-normal">No hay postulantes registrados</h5>
                                        <p class="text-muted small mb-0">Utilice el botón superior para ingresar nuevos estudiantes al padrón.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                @if($postulantes->hasPages())
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 bg-light rounded-3 p-3 border">
                        <div>
                            <small class="text-muted fw-medium">
                                Mostrando <span class="text-dark fw-bold">{{ $postulantes->firstItem() }}</span> a <span class="text-dark fw-bold">{{ $postulantes->lastItem() }}</span> de <span class="text-dark fw-bold">{{ $postulantes->total() }}</span> resultados
                            </small>
                        </div>
                        <div>
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                @if ($postulantes->onFirstPage())
                                    <button class="btn btn-white btn-sm border text-muted px-3 py-2" disabled>
                                        <i class="fas fa-chevron-left me-1"></i> Anterior
                                    </button>
                                @else
                                    <a href="{{ $postulantes->previousPageUrl() }}" class="btn btn-white btn-sm border px-3 py-2 text-dark hover-light">
                                        <i class="fas fa-chevron-left me-1 text-primary-custom"></i> Anterior
                                    </a>
                                @endif
                                
                                @if ($postulantes->hasMorePages())
                                    <a href="{{ $postulantes->nextPageUrl() }}" class="btn btn-white btn-sm border px-3 py-2 text-dark hover-light">
                                        Siguiente <i class="fas fa-chevron-right ms-1 text-primary-custom"></i>
                                    </a>
                                @else
                                    <button class="btn btn-white btn-sm border text-muted px-3 py-2" disabled>
                                        Siguiente <i class="fas fa-chevron-right ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Cabecera personalizada con la identidad de color */
    .custom-table-header {
        background-color: #0a2b5e !important;
    }
    
    /* Efecto hover suave para entradas de datos */
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }
    
    /* Botón de envío de búsqueda corporativo */
    .btn-action {
        background-color: #0a2b5e;
        color: white;
        transition: background-color 0.2s;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: white;
    }

    /* Badges de estados con bajo contraste */
    .bg-success-soft {
        background-color: rgba(40, 167, 69, 0.1);
    }
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.15);
    }
    .bg-primary-soft {
        background-color: rgba(10, 43, 94, 0.08);
    }
    
    .text-primary-custom {
        color: #0a2b5e;
    }
    .text-warning-custom {
        color: #d39e00;
    }

    /* Estilizado e interactividad para íconos de la tabla */
    .action-icon-btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .action-icon-btn:hover {
        transform: scale(1.15);
        background-color: rgba(0, 0, 0, 0.05) !important;
    }

    /* Clases utilitarias de texto */
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    
    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
    }
    .hover-light:hover {
        background-color: #f8f9fa !important;
    }
    .btn-white {
        background-color: #ffffff;
    }
</style>
@endpush
@endsection