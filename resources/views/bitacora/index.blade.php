@extends('layouts.app')

@section('title', 'Bitácora del Sistema')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="metric-icon-box bg-white bg-opacity-10 rounded-3 me-3 text-white">
                        <i class="fas fa-history fa-lg"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold text-white">Bitácora de Auditoría del Sistema</h4>
                        <p class="mb-0 text-white-50 small mt-1">Historial cronológico de operaciones, modificaciones de datos y trazabilidad de seguridad de usuarios</p>
                    </div>
                </div>
                <div>
                    <form action="{{ route('bitacora.limpiar') }}" method="POST" onsubmit="return confirm('¿Está seguro de limpiar toda la bitácora? Esta acción no se puede deshacer y eliminará el historial de auditoría.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-soft border border-danger border-opacity-20 font-size-sm fw-bold px-3 py-1.8 rounded-3 shadow-2xs text-white hover-up">
                            <i class="fas fa-trash me-1.5 font-size-xs"></i> Limpiar Bitácora
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            @if($registros->isEmpty())
                <div class="alert alert-info border-0 rounded-3 bg-primary-soft text-primary-custom text-center py-5 mb-0 shadow-2xs">
                    <div class="indicator-circle-bg bg-white bg-opacity-50 text-primary-custom mx-auto mb-3 shadow-3xs" style="width: 54px; height: 54px; font-size: 1.4rem;">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="fw-bold text-dark font-size-md">No existen registros en la bitácora</h5>
                    <p class="text-secondary small mb-0 max-width-text mx-auto mt-1">Las acciones, modificaciones y eventos de seguridad ejecutados por los usuarios se registrarán de forma automatizada en este panel.</p>
                </div>
            @else
                <div class="table-responsive rounded-3 border bg-white shadow-sm">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="custom-table-header text-white">
                            <tr>
                                <th class="py-2.5 px-3 text-center" style="width: 75px;">ID</th>
                                <th class="py-2.5" style="width: 150px;">Usuario</th>
                                <th class="py-2.5" style="width: 130px;">Operación</th>
                                <th class="py-2.5" style="width: 140px;">Tabla Afectada</th>
                                <th class="text-center py-2.5" style="width: 110px;">Registro ID</th>
                                <th class="py-2.5">Detalles del Evento</th>
                                <th class="py-2.5" style="width: 125px;">Dirección IP</th>
                                <th class="py-2.5" style="width: 165px;">Fecha / Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registros as $r)
                            <tr class="row-hover-effect">
                                <td class="text-center px-3 font-monospace font-size-xs text-secondary fw-semibold">
                                    {{ $r->id }}
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-dark font-size-sm">
                                        {{ $r->usuario }}
                                    </div>
                                </td>
                                
                                <td>
                                    @php
                                        $accionLower = strtolower($r->accion);
                                        $badgeColorClase = 'bg-secondary-soft text-secondary';
                                        if(str_contains($accionLower, 'insert') || str_contains($accionLower, 'crear') || str_contains($accionLower, 'store')) {
                                            $badgeColorClase = 'bg-success-soft text-success border border-success border-opacity-10';
                                        } elseif(str_contains($accionLower, 'update') || str_contains($accionLower, 'edit') || str_contains($accionLower, 'modific')) {
                                            $badgeColorClase = 'bg-warning-soft text-warning-custom border border-warning border-opacity-10';
                                        } elseif(str_contains($accionLower, 'delete') || str_contains($accionLower, 'elimin') || str_contains($accionLower, 'destroy')) {
                                            $badgeColorClase = 'bg-danger-soft text-danger border border-danger border-opacity-10';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeColorClase }} px-2 py-1 rounded font-size-xs fw-bold tracking-wide text-uppercase d-inline-block text-truncate max-width-action">
                                        {{ $r->accion }}
                                    </span>
                                </td>
                                
                                <td class="font-size-xs text-dark fw-medium font-monospace">
                                    {{ $r->tabla_afectada ?? '-' }}
                                </td>
                                
                                <td class="text-center font-monospace font-size-xs text-secondary fw-bold">
                                    {{ $r->text_id ?? $r->registro_id ?? '-' }}
                                </td>
                                
                                <td class="font-size-xs text-secondary text-wrap-cell">
                                    {{ $r->detalles ?? '-' }}
                                </td>
                                
                                <td class="font-monospace font-size-xs text-muted">
                                    <i class="fas fa-network-wired font-size-2xs opacity-50 me-1"></i>{{ $r->ip ?? '-' }}
                                </td>
                                
                                <td class="font-monospace font-size-xs text-dark fw-medium">
                                    {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($registros->hasPages())
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mt-4 pt-2 border-top">
                        <div>
                            <small class="text-muted font-size-xs">
                                Mostrando registros <strong class="text-dark font-monospace">{{ $registros->firstItem() }}</strong> al <strong class="text-dark font-monospace">{{ $registros->lastItem() }}</strong> de un universo de <strong class="text-dark font-monospace">{{ $registros->total() }}</strong> entradas de auditoría
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            @if ($registros->onFirstPage())
                                <button class="btn btn-light font-size-xs fw-bold px-3 py-1.8 rounded-3 border text-muted shadow-3xs" disabled>
                                    <i class="fas fa-chevron-left me-1"></i> Anterior
                                </button>
                            @else
                                <a href="{{ $registros->previousPageUrl() }}" class="btn btn-white font-size-xs fw-bold px-3 py-1.8 rounded-3 border text-primary-custom shadow-2xs hover-up">
                                    <i class="fas fa-chevron-left me-1"></i> Anterior
                                </a>
                            @endif
                            
                            @if ($registros->hasMorePages())
                                <a href="{{ $registros->nextPageUrl() }}" class="btn btn-white font-size-xs fw-bold px-3 py-1.8 rounded-3 border text-primary-custom shadow-2xs hover-up">
                                    Siguiente <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn btn-light font-size-xs fw-bold px-3 py-1.8 rounded-3 border text-muted shadow-3xs" disabled>
                                    Siguiente <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras visuales fijas e institucionales */
    .custom-table-header {
        background-color: #0a2b5e !important;
    }
    .metric-icon-box {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Esquemas cromáticos suavizados para Badges */
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.11); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.11); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.14); }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.12); }
    
    .btn-danger-soft {
        background-color: rgba(220, 53, 69, 0.15);
        color: #f8d7da !important;
        transition: background-color 0.2s;
    }
    .btn-danger-soft:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .btn-white {
        background-color: #ffffff;
        color: #212529;
    }

    .text-primary-custom { color: #0a2b5e; }
    .text-warning-custom { color: #b78a02 !important; }

    .indicator-circle-bg {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Clases utilitarias y tipografías */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .py-1.8 { padding-top: 0.45rem; padding-bottom: 0.45rem; }
    .me-1.5 { margin-right: 0.35rem; }
    .ms-1 { margin-left: 0.25rem; }
    
    .font-size-md { font-size: 1.05rem; }
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.06); }
    .tracking-wide { letter-spacing: 0.03em; }
    .max-width-text { max-width: 480px; }
    .max-width-action { max-width: 120px; }
    
    /* Control de texto largo en columnas de detalle */
    .text-wrap-cell {
        max-width: 280px;
        white-space: normal;
        word-break: break-word;
    }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush