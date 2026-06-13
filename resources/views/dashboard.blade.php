@extends('layouts.app')

@section('title', 'Dashboard - Sistema CUP FICCT')

@section('content')
<div class="container-fluid px-2 px-md-4 py-3">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 text-white overflow-hidden header-gradient">
                <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative">
                    <div class="position-relative" style="z-index: 2;">
                        <h3 class="mb-0 fw-bold d-flex align-items-center">
                            <i class="fas fa-graduation-cap me-3 p-2 bg-white bg-opacity-10 rounded-3"></i>
                            Panel Administrativo
                        </h3>
                        <p class="mb-0 mt-2 text-white-50 fw-medium">
                            Sistema de Admisión Universitaria — Facultad FICCT
                        </p>
                    </div>
                    <i class="fas fa-university fa-5x position-absolute end-0 bottom-0 text-white opacity-10 me-4 d-none d-sm-block" style="transform: translateY(15px);"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 kpi-card">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Total Inscritos</span>
                        <h2 class="mb-0 fw-bold" style="color: #0a2b5e;">{{ number_format($totalInscritos) }}</h2>
                    </div>
                    <div class="rounded-4 p-3 d-flex align-items-center justify-content-center" style="background: rgba(10, 43, 94, 0.08); width: 55px; height: 55px;">
                        <i class="fas fa-users fa-lg" style="color: #0a2b5e;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 kpi-card">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Aprobados</span>
                        <h2 class="mb-0 fw-bold text-success">{{ number_format($totalAprobados) }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 kpi-card">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Reprobados</span>
                        <h2 class="mb-0 fw-bold text-danger">{{ number_format($totalReprobados) }}</h2>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-times-circle fa-lg text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 kpi-card">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1">Grupos Habilitados</span>
                        <h2 class="mb-0 fw-bold text-info">{{ number_format($totalGrupos) }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-4 p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fas fa-layer-group fa-lg text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-lock me-2 opacity-75"></i> Módulo de Autenticación
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-sign-in-alt me-2 text-muted" style="width: 20px;"></i> <strong>CU-01:</strong> Iniciar Sesión</div>
                            <span class="badge rounded-pill bg-success-soft text-success"><i class="fas fa-check"></i> Activo</span>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-sign-out-alt me-2 text-muted" style="width: 20px;"></i> <strong>CU-02:</strong> Cerrar Sesión</div>
                            <span class="badge rounded-pill bg-success-soft text-success"><i class="fas fa-check"></i> Activo</span>
                        </div>
                        <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-key me-2 text-muted" style="width: 20px;"></i> <strong>CU-03:</strong> Recuperar Contraseña</div>
                            <a href="{{ route('password.request') }}" class="btn btn-sm btn-action rounded-3 px-3">
                                Gestionar <i class="fas fa-arrow-right ms-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">3 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-users me-2 opacity-75"></i> Registro de Postulantes
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-user-plus me-2 text-muted" style="width: 20px;"></i> <strong>CU-04:</strong> Registrar</div>
                            <a href="{{ route('postulantes.create') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-edit me-2 text-muted" style="width: 20px;"></i> <strong>CU-05:</strong> Modificar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-warning rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-trash me-2 text-muted" style="width: 20px;"></i> <strong>CU-06:</strong> Eliminar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-danger rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-search me-2" style="width: 20px; color: #0a2b5e;"></i> <strong>CU-07:</strong> Buscar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-list me-2 text-muted" style="width: 20px;"></i> <strong>CU-08:</strong> Listar Todos</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-secondary rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-exchange-alt me-2 text-muted" style="width: 20px;"></i> <strong>CU-13:</strong> Segunda Opción</div>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill"><i class="fas fa-magic me-1"></i> Automatizado</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">6 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-clipboard-list me-2 opacity-75"></i> Gestión de Exámenes
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-pen me-2 text-muted" style="width: 20px;"></i> <strong>CU-09:</strong> Registrar Notas</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-edit me-2 text-muted" style="width: 20px;"></i> <strong>CU-10:</strong> Editar Notas</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-warning rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-calculator me-2 text-muted" style="width: 20px;"></i> <strong>CU-11:</strong> Cálculo Promedio</div>
                            <span class="badge bg-light text-dark border rounded-pill font-monospace">(N1+N2+N3)/3</span>
                        </div>
                        <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-flag-checkered me-2 text-muted" style="width: 20px;"></i> <strong>CU-12:</strong> Evaluar Estado</div>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill">Nota ≥ 60</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">4 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-layer-group me-2 opacity-75"></i> Distribución de Grupos
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-calculator me-2 text-muted" style="width: 20px;"></i> <strong>CU-14:</strong> Calcular Capacidades</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-magic me-2 text-muted" style="width: 20px;"></i> <strong>CU-15:</strong> Asignar Estudiantes</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-eye me-2 text-muted" style="width: 20px;"></i> <strong>CU-18:</strong> Ver Listas de Grupos</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">3 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-chalkboard-user me-2 opacity-75"></i> Planificación y Docentes
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-user-friends me-2 text-muted" style="width: 20px;"></i> <strong>CU-16:</strong> Asignar a Grupo</div>
                            <a href="{{ route('docentes.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-calendar-alt me-2 text-muted" style="width: 20px;"></i> <strong>CU-17:</strong> Horarios / Aulas</div>
                            <a href="{{ route('horarios.create') }}" class="btn btn-sm btn-warning rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-user-check me-2 text-muted" style="width: 20px;"></i> <strong>CU-19:</strong> Registrar Plantel</div>
                            <a href="{{ route('docentes.create') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-clock me-2 text-muted" style="width: 20px;"></i> <strong>CU-20:</strong> Carga Horaria</div>
                            <a href="{{ route('docente.carga-horaria') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2.5 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-check-circle me-2 text-muted" style="width: 20px;"></i> <strong>CU-21:</strong> Control Asistencia</div>
                            <a href="{{ route('asistencias.create') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">5 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-chart-bar me-2 opacity-75"></i> Inteligencia y Reportes
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-list me-2 text-muted" style="width: 20px;"></i> <strong>CU-22:</strong> Lista de Asignación</div>
                            <a href="{{ route('reportes.lista') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-chart-line me-2 text-muted" style="width: 20px;"></i> <strong>CU-23:</strong> Rendimiento General</div>
                            <a href="{{ route('reportes.aprobados') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-chart-pie me-2 text-muted" style="width: 20px;"></i> <strong>CU-24:</strong> Estadísticas Materias</div>
                            <a href="{{ route('reportes.estadisticas') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-tachometer-alt me-2 text-muted" style="width: 20px;"></i> <strong>CU-25:</strong> Monitor de KPIs</div>
                            <span class="badge rounded-pill bg-primary-soft text-primary-custom fw-semibold"><i class="fas fa-eye me-1"></i> Leyendo</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">4 Casos de Uso</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 modulo-card">
                <div class="card-header border-0 rounded-top-4 py-3 header-gradient text-white">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="fas fa-exchange-alt me-2 opacity-75"></i> Intercambio de Datos
                    </h5>
                </div>
                <div class="card-body py-2">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-upload me-2 text-muted" style="width: 20px;"></i> <strong>CU-26:</strong> Importar Padrones</div>
                            <a href="{{ route('importacion.index') }}" class="btn btn-sm btn-action rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-bottom px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-file-excel me-2" style="width: 20px; color: #28a745;"></i> <strong>CU-27:</strong> Descargar Excel</div>
                            <a href="{{ route('export.excel') }}" class="btn btn-sm btn-success rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                        <div class="list-group-item border-0 px-0 py-3 d-flex justify-content-between align-items-center row-hover">
                            <div><i class="fas fa-file-pdf me-2" style="width: 20px; color: #dc3545;"></i> <strong>CU-27:</strong> Descargar PDF</div>
                            <a href="{{ route('export.pdf') }}" class="btn btn-sm btn-danger rounded-3 px-3">Ir <i class="fas fa-arrow-right ms-1 text-xs"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3 pt-0">
                    <span class="badge rounded-3 px-3 py-2 badge-count">3 Casos de Uso</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 header-gradient text-white">
                <div class="card-body py-3 text-center">
                    <p class="mb-0 fw-medium">
                        <i class="fas fa-check-circle me-2 text-success-light"></i>
                        Estructura Operativa Completa | <strong class="text-warning">27/27 Casos de Uso Verificados</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Degradado e identidad visual */
    .header-gradient {
        background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%) !important;
    }
    
    /* Efectos hover para tarjetas de módulos */
    .modulo-card {
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }
    .modulo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.5rem 1.5rem rgba(10, 43, 94, 0.12) !important;
    }

    /* Resaltar filas de los list-groups */
    .row-hover {
        transition: background-color 0.15s ease, padding-left 0.15s ease;
    }
    .row-hover:hover {
        background-color: rgba(10, 43, 94, 0.02);
        padding-left: 4px !important;
    }

    /* Estilos de botones personalizados */
    .btn-action {
        background-color: #0a2b5e;
        color: #ffffff;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        background-color: #143f7d;
        color: #ffffff;
        box-shadow: 0 3px 8px rgba(10, 43, 94, 0.2);
    }

    /* Badges estilizados de bajo contraste */
    .bg-success-soft {
        background-color: rgba(40, 167, 69, 0.12);
    }
    .bg-primary-soft {
        background-color: rgba(10, 43, 94, 0.1);
    }
    .text-primary-custom {
        color: #0a2b5e;
    }
    .badge-count {
        background-color: rgba(10, 43, 94, 0.08);
        color: #0a2b5e;
        font-weight: 600;
    }
    .text-success-light {
        color: #2ed573;
    }
    .text-xs {
        font-size: 0.75rem;
    }

    /* Animaciones suaves para KPIs */
    .kpi-card {
        transition: transform 0.2s ease;
    }
    .kpi-card:hover {
        transform: scale(1.02);
    }
</style>
@endpush
@endsection