<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CUP FICCT - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fc; overflow-x: hidden; margin: 0; padding: 0; }
        
        /* CONTENEDOR PRINCIPAL FLEX */
        .app-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        /* BARRA LATERAL (SIDEBAR) */
        .sidebar {
            width: 280px;
            min-width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #0a2b5e 0%, #061c3f 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .sidebar-brand {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-nav-container {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 30px;
        }

        .nav-section-title {
            font-size: 0.72rem;
            letter-spacing: 1.2px;
            opacity: 0.55;
            font-weight: 700;
        }
        
        /* ENLACES DE LA SIDEBAR */
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 11px 18px;
            margin: 3px 12px;
            border-radius: 10px;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link i { 
            margin-right: 12px; 
            width: 20px; 
            text-align: center;
            font-size: 1.05rem;
            transition: transform 0.2s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }
        
        .sidebar .nav-link.active { 
            background: #ffc107 !important; 
            color: #0a2b5e !important; 
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.2);
        }

        .sidebar .nav-link.active i {
            color: #0a2b5e !important;
        }

        /* SECCIÓN DE CONTENIDO WRAPPER */
        .content-wrapper {
            flex-grow: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-width: 0; /* Previene desbordamiento de componentes hijos flex */
            min-height: 100vh;
        }

        /* NAVBAR SUPERIOR */
        .navbar-top {
            background: white;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            padding: 15px 24px;
            height: 70px;
        }

        main {
            flex-grow: 1;
        }

        /* BOTÓN DE MENÚ FLOTANTE MÓVIL */
        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1050;
            background: #0a2b5e;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(10, 43, 94, 0.25);
            display: none;
        }

        /* CAPA OSCURA DE ENFOQUE (OVERLAY) */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1030;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.active { display: block; opacity: 1; }

        /* SCROLLBAR PERSONALIZADO */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1a4a8a; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #0a2b5e; }

        footer { 
            background: white; 
            padding: 18px 0; 
            text-align: center; 
            border-top: 1px solid #dee2e6;
            margin-top: auto;
        }

        /* RESPONSIVIDAD GENERAL */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open { 
                transform: translateX(0); 
            }
            .content-wrapper {
                margin-left: 0;
            }
            .menu-toggle { 
                display: block; 
            }
            .navbar-top {
                padding-left: 75px;
            }
        }
    </style>
    @stack('styles')
</head>
@include('components.voice-assistant')
<body>

    @auth
    <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="app-layout">
        
        <div class="sidebar" id="sidebar">
            <div class="sidebar-brand text-center py-4 px-3">
                <i class="fas fa-laptop-code fa-3x text-white mb-2"></i>
                <h5 class="text-white mb-0 fw-bold tracking-wide">CUP FICCT</h5>
                <small class="text-white-50">Admisión Universitaria</small>
            </div>
            
            <div class="sidebar-nav-container">
                <nav class="nav flex-column">
                    
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    @if(Auth::user()->isAdmin() || Auth::user()->isCoordinador())
                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Gestión</div>
                        
                        <a class="nav-link {{ request()->routeIs('postulantes.*') ? 'active' : '' }}" href="{{ route('postulantes.index') }}">
                            <i class="fas fa-users"></i> Postulantes
                        </a>
                        <a class="nav-link {{ request()->routeIs('grupos.*') ? 'active' : '' }}" href="{{ route('grupos.index') }}">
                            <i class="fas fa-layer-group"></i> Grupos
                        </a>
                        <a class="nav-link {{ request()->routeIs('horarios.*') ? 'active' : '' }}" href="{{ route('horarios.create') }}">
                            <i class="fas fa-calendar-alt"></i> Horarios
                        </a>
                        <a class="nav-link {{ request()->routeIs('asistencias.*') ? 'active' : '' }}" href="{{ route('asistencias.create') }}">
                            <i class="fas fa-check-circle"></i> Asistencia
                        </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}" href="{{ route('docentes.index') }}">
                            <i class="fas fa-chalkboard-user"></i> Docentes
                        </a>
                        
                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Datos</div>
                        <a class="nav-link {{ request()->routeIs('importacion.*') ? 'active' : '' }}" href="{{ route('importacion.index') }}">
                            <i class="fas fa-upload"></i> Importar
                        </a>
                        <a class="nav-link {{ request()->routeIs('exportacion.*') ? 'active' : '' }}" href="{{ route('exportacion.index') }}">
                            <i class="fas fa-download"></i> Exportar
                        </a>
                        <a class="nav-link {{ request()->routeIs('importacion.usuarios') ? 'active' : '' }}" href="{{ route('importacion.usuarios') }}">
                            <i class="fas fa-user-plus"></i> Importar Usuarios
                        </a>

                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Reportes</div>
                        <a class="nav-link {{ request()->routeIs('reportes.lista') ? 'active' : '' }}" href="{{ route('reportes.lista') }}">
                            <i class="fas fa-list"></i> Lista General
                        </a>
                        <a class="nav-link {{ request()->routeIs('cupos.index') ? 'active' : '' }}" href="{{ route('cupos.index') }}">
                            <i class="fas fa-graduation-cap"></i> Cupos por Carrera
                        </a>
                        <a class="nav-link {{ request()->routeIs('asignacion.index') ? 'active' : '' }}" href="{{ route('asignacion.index') }}">
                            <i class="fas fa-calculator"></i> Asignar por Mérito
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.aprobados') ? 'active' : '' }}" href="{{ route('reportes.aprobados') }}">
                            <i class="fas fa-chart-line"></i> Aprobados/Reprobados
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.estadisticas') ? 'active' : '' }}" href="{{ route('reportes.estadisticas') }}">
                            <i class="fas fa-chart-pie"></i> Estadísticas Materia
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.promedios') ? 'active' : '' }}" href="{{ route('reportes.promedios') }}">
                            <i class="fas fa-calculator"></i> Promedios Generales
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.docentes-por-grupos') ? 'active' : '' }}" href="{{ route('reportes.docentes-por-grupos') }}">
                            <i class="fas fa-chalkboard-user"></i> Docentes por Grupos
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.grupos-mas-aprobados') ? 'active' : '' }}" href="{{ route('reportes.grupos-mas-aprobados') }}">
                            <i class="fas fa-trophy"></i> Grupos Más Aprobados
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.grupos-habilitados') ? 'active' : '' }}" href="{{ route('reportes.grupos-habilitados') }}">
                            <i class="fas fa-calculator"></i> Grupos Habilitados
                        </a>
                        <a class="nav-link" href="{{ route('bitacora.index') }}">
                            <i class="fas fa-history"></i> Bitácora
                        </a>
                        <a class="nav-link" href="{{ route('asistencias.index') }}">
                            <i class="fas fa-calendar-check"></i> Listado Asistencias
                        </a>
                    @endif

                    @if(Auth::user()->isCoordinador() && !Auth::user()->isAdmin())
                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Reportes</div>
                        <a class="nav-link {{ request()->routeIs('reportes.lista') ? 'active' : '' }}" href="{{ route('reportes.lista') }}">
                            <i class="fas fa-list"></i> Lista General
                        </a>
                        <a class="nav-link {{ request()->routeIs('cupos.index') ? 'active' : '' }}" href="{{ route('cupos.index') }}">
                            <i class="fas fa-graduation-cap"></i> Cupos por Carrera
                        </a>
                        <a class="nav-link {{ request()->routeIs('asignacion.index') ? 'active' : '' }}" href="{{ route('asignacion.index') }}">
                            <i class="fas fa-calculator"></i> Asignar por Mérito
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.aprobados') ? 'active' : '' }}" href="{{ route('reportes.aprobados') }}">
                            <i class="fas fa-chart-line"></i> Aprobados/Reprobados
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.estadisticas') ? 'active' : '' }}" href="{{ route('reportes.estadisticas') }}">
                            <i class="fas fa-chart-pie"></i> Estadísticas Materia
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.promedios') ? 'active' : '' }}" href="{{ route('reportes.promedios') }}">
                            <i class="fas fa-calculator"></i> Promedios Generales
                        </a>
                    @endif

                    @if(Auth::user()->isDocente())
                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Docente</div>
                        <a class="nav-link {{ request()->routeIs('docente.carga-horaria') ? 'active' : '' }}" href="{{ route('docente.carga-horaria') }}">
                            <i class="fas fa-clock"></i> Mi Carga Horaria
                        </a>
                        <a class="nav-link {{ request()->routeIs('asistencias.*') ? 'active' : '' }}" href="{{ route('asistencias.create') }}">
                            <i class="fas fa-check-circle"></i> Registrar Asistencia
                        </a>
                    @endif

                    @if(Auth::user()->isPostulante())
                        <div class="nav-section-title text-white-50 px-4 mt-3 mb-1 text-uppercase">Mi Cuenta</div>
                        <a class="nav-link {{ request()->routeIs('postulante.dashboard') ? 'active' : '' }}" href="{{ route('postulante.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Mi Panel
                        </a>
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @endif
                </nav>
            </div>
        </div>

        <div class="content-wrapper">
            
            <nav class="navbar-top d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-dark d-none d-md-block">@yield('header', 'Panel de Control')</h4>
                
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-light border dropdown-toggle fw-medium px-3 rounded-3" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            @if(Auth::user()->isAdmin())
                                <span class="badge ms-2" style="background: #0a2b5e;">Admin</span>
                            @elseif(Auth::user()->isDocente())
                                <span class="badge bg-info ms-2">Docente</span>
                            @elseif(Auth::user()->isCoordinador())
                                <span class="badge bg-warning text-dark ms-2">Coordinador</span>
                            @elseif(Auth::user()->isPostulante())
                                <span class="badge bg-success ms-2">Postulante</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="p-3 p-md-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3">
                        <i class="fas fa-exclamation-triangle override me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
            
            <footer>
                <p class="mb-0 text-muted small">&copy; {{ date('Y') }} Sistema CUP — Facultad FICCT — UAGRM</p>
            </footer>
        </div>
    </div>
    @endauth

    @guest
        <div class="w-100">
            @yield('content')
        </div>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
            });
        }
        
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        function confirmDelete(formId) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                document.getElementById(formId).submit();
            }
        }

        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        window.addEventListener('resize', function() {
            if (window.innerWidth > 992 && sidebar) {
                sidebar.classList.remove('mobile-open');
                if(overlay) overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>