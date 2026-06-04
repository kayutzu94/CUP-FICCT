@extends('layouts.app')

@section('title', 'Dashboard - Sistema CUP FICCT')

@section('content')
<div class="container-fluid px-2 px-md-4">
    
    <!-- ENCABEZADO SIMPLE -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                <div class="card-body py-3">
                    <div>
                        <h3 class="mb-0 fw-bold text-white"><i class="fas fa-graduation-cap me-2"></i>Panel Administrativo</h3>
                        <p class="mb-0 mt-1 text-white-50">Sistema de Admisión Universitaria - Facultad FICCT</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row mb-4 g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase">Total Inscritos</span>
                            <h2 class="mb-0 fw-bold" style="color: #0a2b5e;">{{ number_format($totalInscritos) }}</h2>
                        </div>
                        <div class="rounded-3 p-3" style="background: rgba(10, 43, 94, 0.1);">
                            <i class="fas fa-users fa-2x" style="color: #0a2b5e;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase">Aprobados</span>
                            <h2 class="mb-0 fw-bold text-success">{{ number_format($totalAprobados) }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase">Reprobados</span>
                            <h2 class="mb-0 fw-bold text-danger">{{ number_format($totalReprobados) }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase">Grupos</span>
                            <h2 class="mb-0 fw-bold text-info">{{ number_format($totalGrupos) }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-layer-group fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS - FILA 1 -->
    <div class="row g-4 mb-4">
        
        <!-- Módulo Autenticación -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-lock me-2"></i> Módulo de Autenticación</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-sign-in-alt me-2" style="color: #0a2b5e;"></i> <strong>CU-01:</strong> Iniciar Sesión</div>
                            <span class="badge" style="background: #0a2b5e;">✓</span>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-sign-out-alt me-2" style="color: #dc3545;"></i> <strong>CU-02:</strong> Cerrar Sesión</div>
                            <span class="badge" style="background: #0a2b5e;">✓</span>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-key me-2" style="color: #0a2b5e;"></i> <strong>CU-03:</strong> Recuperar Contraseña</div>
                            <a href="{{ route('password.request') }}" class="btn btn-sm btn-link p-0" style="color: #0a2b5e;">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">3 casos de uso</span>
                </div>
            </div>
        </div>

        <!-- Módulo Registro Postulante -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-users me-2"></i> Módulo de Registro de Postulante</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-user-plus me-2" style="color: #0a2b5e;"></i> <strong>CU-04:</strong> Registrar</div>
                            <a href="{{ route('postulantes.create') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-edit me-2" style="color: #ffc107;"></i> <strong>CU-05:</strong> Modificar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-warning">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-trash me-2" style="color: #dc3545;"></i> <strong>CU-06:</strong> Eliminar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-danger">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-search me-2" style="color: #0a2b5e;"></i> <strong>CU-07:</strong> Buscar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-list me-2" style="color: #6c757d;"></i> <strong>CU-08:</strong> Listar</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-secondary">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-exchange-alt me-2" style="color: #0a2b5e;"></i> <strong>CU-13:</strong> Segunda Opción</div>
                            <span class="badge" style="background: #0a2b5e;">Auto</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">6 casos de uso</span>
                </div>
            </div>
        </div>

        <!-- Módulo Exámenes -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-clipboard-list me-2"></i> Módulo de Exámenes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-pen me-2" style="color: #0a2b5e;"></i> <strong>CU-09:</strong> Registrar Notas</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-edit me-2" style="color: #ffc107;"></i> <strong>CU-10:</strong> Editar Notas</div>
                            <a href="{{ route('postulantes.index') }}" class="btn btn-sm btn-warning">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-calculator me-2" style="color: #0a2b5e;"></i> <strong>CU-11:</strong> Promedio</div>
                            <span class="badge" style="background: #0a2b5e;">(N1+N2+N3)/3</span>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-flag-checkered me-2" style="color: #0a2b5e;"></i> <strong>CU-12:</strong> Estado</div>
                            <span class="badge" style="background: #0a2b5e;">≥60 Aprobado</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">4 casos de uso</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS - FILA 2 -->
    <div class="row g-4 mb-4">
        
        <!-- Módulo Asignación de Grupos -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-layer-group me-2"></i> Módulo de Asignación de Grupos</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-calculator me-2" style="color: #0a2b5e;"></i> <strong>CU-14:</strong> Calcular Grupos</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-magic me-2" style="color: #0a2b5e;"></i> <strong>CU-15:</strong> Asignar Estudiantes</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-eye me-2" style="color: #0a2b5e;"></i> <strong>CU-18:</strong> Ver Estudiantes</div>
                            <a href="{{ route('grupos.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">3 casos de uso</span>
                </div>
            </div>
        </div>

        <!-- Módulo Docentes -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-chalkboard-user me-2"></i> Módulo de Docentes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-user-friends me-2" style="color: #0a2b5e;"></i> <strong>CU-16:</strong> Asignar Docente</div>
                            <a href="{{ route('docentes.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-calendar-alt me-2" style="color: #ffc107;"></i> <strong>CU-17:</strong> Horario/Aula</div>
                            <a href="{{ route('horarios.create') }}" class="btn btn-sm btn-warning">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-user-check me-2" style="color: #0a2b5e;"></i> <strong>CU-19:</strong> Registrar Docente</div>
                            <a href="{{ route('docentes.create') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-clock me-2" style="color: #0a2b5e;"></i> <strong>CU-20:</strong> Carga Horaria</div>
                            <a href="{{ route('docente.carga-horaria') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-check-circle me-2" style="color: #0a2b5e;"></i> <strong>CU-21:</strong> Asistencia</div>
                            <a href="{{ route('asistencias.create') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">5 casos de uso</span>
                </div>
            </div>
        </div>

        <!-- Módulo Reportes -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-chart-bar me-2"></i> Módulo de Reportes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-list me-2" style="color: #0a2b5e;"></i> <strong>CU-22:</strong> Lista General</div>
                            <a href="{{ route('reportes.lista') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-chart-line me-2" style="color: #0a2b5e;"></i> <strong>CU-23:</strong> Aprobados/Reprobados</div>
                            <a href="{{ route('reportes.aprobados') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-chart-pie me-2" style="color: #0a2b5e;"></i> <strong>CU-24:</strong> Estadísticas</div>
                            <a href="{{ route('reportes.estadisticas') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-tachometer-alt me-2" style="color: #0a2b5e;"></i> <strong>CU-25:</strong> Dashboard KPIs</div>
                            <span class="badge" style="background: #0a2b5e;">Actual</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">4 casos de uso</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MÓDULOS - FILA 3 -->
    <div class="row g-4 mb-4">
        
        <!-- Módulo Importación/Exportación -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                    <h5 class="mb-0 fw-bold text-white"><i class="fas fa-exchange-alt me-2"></i> Módulo de Importación/Exportación</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-upload me-2" style="color: #0a2b5e;"></i> <strong>CU-26:</strong> Importación</div>
                            <a href="{{ route('importacion.index') }}" class="btn btn-sm" style="background: #0a2b5e; color: white;">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-file-excel me-2" style="color: #28a745;"></i> <strong>CU-27:</strong> Exportar Excel</div>
                            <a href="{{ route('export.excel') }}" class="btn btn-sm btn-success">Ir</a>
                        </div>
                        <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-file-pdf me-2" style="color: #dc3545;"></i> <strong>CU-27:</strong> Exportar PDF</div>
                            <a href="{{ route('export.pdf') }}" class="btn btn-sm btn-danger">Ir</a>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <span class="badge px-3 py-2" style="background: #0a2b5e;">3 casos de uso</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #0a2b5e 0%, #1a4a8a 100%);">
                <div class="card-body py-3 text-center">
                    <p class="mb-0 text-white">
                        <i class="fas fa-check-circle me-2"></i>
                        Sistema 100% funcional | <strong>27/27 Casos de Uso Implementados</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection