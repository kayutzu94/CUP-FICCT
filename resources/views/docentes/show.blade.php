@extends('layouts.app')

@section('title', 'Detalles del Docente')

@section('content')
<div class="container-fluid px-0 py-2">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        
        <div class="card-header border-0 py-3.5" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
            <div class="d-flex align-items-center">
                <div class="metric-icon-box bg-white rounded-3 me-3 text-primary-custom shadow-2xs">
                    <i class="fas fa-chalkboard-user fa-lg"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-white">Ficha de Información del Docente</h4>
                    <p class="mb-0 text-white-50 small mt-1">Expediente del titular, acreditaciones de postgrado y desglose de grupos académicos asignados</p>
                </div>
            </div>
        </div>
        
        <div class="card-body p-4 bg-light bg-opacity-40">
            
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3 border bg-white shadow-3xs d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-size-3xs fw-bold text-uppercase tracking-wider d-block mb-1">Acreditación Maestría</span>
                            <span class="fw-bold font-size-sm text-dark">Grado de Postgrado</span>
                        </div>
                        @if($docente->tiene_maestria)
                            <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-2xs fw-bold border border-success border-opacity-10">
                                <i class="fas fa-check-circle me-1"></i> Vigente
                            </span>
                        @else
                            <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-2xs fw-bold border border-danger border-opacity-10">
                                <i class="fas fa-times-circle me-1"></i> No Registra
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3 border bg-white shadow-3xs d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-size-3xs fw-bold text-uppercase tracking-wider d-block mb-1">Diplomado Educ. Sup.</span>
                            <span class="fw-bold font-size-sm text-dark">Habilitación Pedagógica</span>
                        </div>
                        @if($docente->tiene_diplomado_educacion)
                            <span class="badge bg-success-soft text-success px-2.5 py-1.5 rounded-pill font-size-2xs fw-bold border border-success border-opacity-10">
                                <i class="fas fa-check-circle me-1"></i> Habilitado
                            </span>
                        @else
                            <span class="badge bg-danger-soft text-danger px-2.5 py-1.5 rounded-pill font-size-2xs fw-bold border border-danger border-opacity-10">
                                <i class="fas fa-times-circle me-1"></i> No Registra
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3 border bg-white shadow-3xs d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted font-size-3xs fw-bold text-uppercase tracking-wider d-block mb-1">Estado en Plataforma</span>
                            <span class="fw-bold font-size-sm text-dark">Disponibilidad Operativa</span>
                        </div>
                        @if($docente->activo)
                            <span class="badge bg-success px-3 py-1.5 rounded-pill font-size-2xs fw-bold border shadow-2xs">
                                <i class="fas fa-signal me-1"></i> Activo
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-1.5 rounded-pill font-size-2xs fw-bold border shadow-2xs">
                                <i class="fas fa-ban me-1"></i> Inactivo
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="bg-white rounded-3 border shadow-3xs p-3 h-100">
                        <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3 border-bottom pb-2">
                            <i class="fas fa-id-card text-secondary me-1"></i> Identificación y Contacto
                        </span>
                        
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Cédula de Identidad</label>
                            <span class="font-monospace font-size-sm text-dark fw-bold bg-light px-2 py-1 rounded border">{{ $docente->ci }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Nombres Completos</label>
                            <span class="font-size-sm text-dark fw-semibold">{{ $docente->nombres }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Apellidos Paterno / Materno</label>
                            <span class="font-size-sm text-dark fw-semibold">{{ $docente->apellidos }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Correo Electrónico Institucional</label>
                            <span class="font-size-sm text-primary-custom fw-medium"><i class="far fa-envelope text-muted me-1.5"></i>{{ $docente->email }}</span>
                        </div>
                        <div class="mb-0">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Teléfono / Celular de Contacto</label>
                            <span class="font-size-sm text-dark fw-medium"><i class="fas fa-phone-alt text-muted me-1.5 font-size-xs"></i>{{ $docente->telefono }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="bg-white rounded-3 border shadow-3xs p-3 h-100">
                        <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3 border-bottom pb-2">
                            <i class="fas fa-graduation-cap text-secondary me-1"></i> Especialización de Cátedra
                        </span>
                        
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Profesión Base</label>
                            <span class="font-size-sm text-dark fw-semibold"><i class="fas fa-briefcase text-muted me-1.5 font-size-xs"></i>{{ $docente->profesion }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Área de Especialidad</label>
                            <span class="font-size-sm text-dark fw-semibold"><i class="fas fa-award text-muted me-1.5 font-size-xs"></i>{{ $docente->especialidad }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="text-secondary font-size-3xs fw-bold text-uppercase mb-1 d-block">Carga de Postgrado Mapeada</label>
                            <span class="font-size-xs text-secondary d-block mt-1">
                                <i class="fas fa-circle font-size-3xs {{ $docente->tiene_maestria ? 'text-success' : 'text-danger' }} me-1.5"></i> Grado de Magíster Oficial
                            </span>
                            <span class="font-size-xs text-secondary d-block mt-1">
                                <i class="fas fa-circle font-size-3xs {{ $docente->tiene_diplomado_educacion ? 'text-success' : 'text-danger' }} me-1.5"></i> Competencias Pedagógicas de Aula
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($docente->asignaciones->count() > 0)
                <div class="mt-4">
                    <span class="text-muted font-size-2xs fw-bold text-uppercase tracking-wider d-block mb-3">
                        <i class="fas fa-layer-group text-secondary me-1"></i> Carga Académica de Cátedras Vinculadas
                    </span>
                    
                    <div class="table-responsive rounded-3 border bg-white shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="custom-table-header text-white">
                                <tr>
                                    <th class="py-3 px-3" style="width: 200px;">Grupo / Módulo</th>
                                    <th class="py-3">Materia / Asignatura</th>
                                    <th class="py-3 text-center" style="width: 180px;">Fecha de Asignación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($docente->asignaciones as $asignacion)
                                <tr class="row-hover-effect">
                                    <td class="px-3">
                                        <span class="badge bg-primary-soft text-primary-custom px-2.5 py-1.5 rounded-3 font-size-xs fw-bold border border-primary border-opacity-10 d-inline-block">
                                            {{ $asignacion->grupo->nombre ?? 'N/A' }}
                                        </span>
                                        @if(isset($asignacion->grupo->codigo))
                                            <span class="text-muted font-monospace font-size-xs ms-1.5">({{ $asignacion->grupo->codigo }})</span>
                                        @endif
                                    </td>
                                    
                                    <td class="fw-semibold font-size-sm text-dark">
                                        {{ $asignacion->materia->nombre ?? 'N/A' }}
                                    </td>
                                    
                                    <td class="text-center font-monospace font-size-sm text-secondary">
                                        <i class="far fa-calendar-alt me-1.5 font-size-xs text-muted"></i>{{ $asignacion->fecha_asignacion->format('d/m/Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="pt-3 border-top d-flex flex-wrap gap-2 justify-content-end mt-4">
                <a href="{{ route('docentes.index') }}" class="btn btn-white font-size-sm fw-bold px-4 py-2.5 rounded-3 border shadow-sm text-secondary hover-up w-100 w-sm-auto text-center">
                    <i class="fas fa-arrow-left me-1.5 font-size-xs"></i> Volver al Listado
                </a>
                <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-warning-custom font-size-sm fw-bold px-4 py-2.5 rounded-3 shadow-sm text-white hover-up w-100 w-sm-auto text-center">
                    <i class="fas fa-edit me-1.5 font-size-xs"></i> Editar Docente
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Estructuras generales institucionales */
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
    
    .btn-warning-custom {
        background-color: #e0a800;
        border: none;
    }
    .btn-warning-custom:hover {
        background-color: #c69500;
        color: white;
    }
    
    .btn-white {
        background-color: #ffffff;
        color: #6c757d;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
        color: #495057;
    }

    .text-primary-custom { color: #0a2b5e; }
    .bg-primary-soft { background-color: rgba(10, 43, 94, 0.08); }
    .bg-success-soft { background-color: rgba(40, 167, 69, 0.12); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.12); }

    .row-hover-effect {
        transition: background-color 0.15s ease;
    }
    .row-hover-effect:hover {
        background-color: rgba(10, 43, 94, 0.02) !important;
    }

    /* Clases utilitarias adaptativas */
    .py-3.5 { padding-top: 1.1rem; padding-bottom: 1.1rem; }
    .py-2.5 { padding-top: 0.65rem; padding-bottom: 0.65rem; }
    .me-1.5 { margin-right: 0.35rem; }
    .ms-1.5 { margin-left: 0.35rem; }
    
    .font-size-sm { font-size: 0.9rem; }
    .font-size-xs { font-size: 0.78rem; }
    .font-size-2xs { font-size: 0.72rem; }
    .font-size-3xs { font-size: 0.66rem; }
    
    .shadow-2xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .shadow-3xs { box-shadow: inset 0 1px 2px rgba(0,0,0,0.04); }
    .tracking-wider { letter-spacing: 0.05em; }

    .hover-up {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .hover-up:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important;
    }
</style>
@endpush