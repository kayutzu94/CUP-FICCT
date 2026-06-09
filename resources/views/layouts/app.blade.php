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
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fc; overflow-x: hidden; }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0a2b5e 0%, #1a4a8a 100%);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                width: 280px;
                z-index: 1050;
            }
            .sidebar.mobile-open { left: 0; }
            .menu-toggle { display: block !important; }
        }
        @media (min-width: 769px) { .menu-toggle { display: none; } }
        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1060;
            background: #0a2b5e;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
            color: white;
        }
        .sidebar .nav-link.active { background: #ffc107; color: #0a2b5e; }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; }
        .navbar-top {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 20px;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.active { display: block; }
        .card { transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1a4a8a; border-radius: 4px; }
        footer { background: white; padding: 15px 0; margin-top: 30px; text-align: center; border-top: 1px solid #dee2e6; }
    </style>
    @stack('styles')
</head>
@include('components.voice-assistant')
<body>
    <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            @auth
            <div class="col-md-3 col-lg-2 sidebar" id="sidebar">
                <div class="text-center py-4">
                    <i class="fas fa-laptop-code fa-3x text-white"></i>
                    <h5 class="text-white mt-2">CUP FICCT</h5>
                    <small class="text-white-50">Admisión Universitaria</small>
                </div>
                <nav class="nav flex-column">
                    <!-- DASHBOARD - Todos pueden ver -->
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    <!-- ADMIN y COORDINADOR pueden ver GESTIÓN -->
                    @if(Auth::user()->isAdmin() || Auth::user()->isCoordinador())
                        <div class="text-white-50 small px-3 mt-3 mb-2">GESTIÓN</div>
                        
                        <!-- Postulantes - Admin y Coordinador pueden ver -->
                        <a class="nav-link {{ request()->routeIs('postulantes.*') ? 'active' : '' }}" href="{{ route('postulantes.index') }}">
                            <i class="fas fa-users"></i> Postulantes
                        </a>
                        
                        <!-- Grupos - Admin y Coordinador pueden ver -->
                        <a class="nav-link {{ request()->routeIs('grupos.*') ? 'active' : '' }}" href="{{ route('grupos.index') }}">
                            <i class="fas fa-layer-group"></i> Grupos
                        </a>
                        
                        <!-- Horarios - Admin y Coordinador pueden ver -->
                        <a class="nav-link {{ request()->routeIs('horarios.*') ? 'active' : '' }}" href="{{ route('horarios.create') }}">
                            <i class="fas fa-calendar-alt"></i> Horarios
                        </a>
                        
                        <!-- Asistencia - Admin y Coordinador pueden ver -->
                        <a class="nav-link {{ request()->routeIs('asistencias.*') ? 'active' : '' }}" href="{{ route('asistencias.create') }}">
                            <i class="fas fa-check-circle"></i> Asistencia
                        </a>
                    @endif

                    <!-- SOLO ADMIN puede ver DOCENTES y DATOS -->
                    @if(Auth::user()->isAdmin())
                        <!-- Docentes - Solo Admin -->
                        <a class="nav-link {{ request()->routeIs('docentes.*') ? 'active' : '' }}" href="{{ route('docentes.index') }}">
                            <i class="fas fa-chalkboard-user"></i> Docentes
                        </a>
                        
                        <div class="text-white-50 small px-3 mt-3 mb-2">DATOS</div>
                        <a class="nav-link {{ request()->routeIs('importacion.*') ? 'active' : '' }}" href="{{ route('importacion.index') }}">
                            <i class="fas fa-upload"></i> Importar
                        </a>
                        <a class="nav-link {{ request()->routeIs('exportacion.*') ? 'active' : '' }}" href="{{ route('exportacion.index') }}">
                            <i class="fas fa-download"></i> Exportar
                        </a>
                        <a class="nav-link {{ request()->routeIs('importacion.usuarios') ? 'active' : '' }}" href="{{ route('importacion.usuarios') }}">
                            <i class="fas fa-user-plus"></i> Importar Usuarios
                        </a>

                        <div class="text-white-50 small px-3 mt-3 mb-2">REPORTES</div>
                        <a class="nav-link {{ request()->routeIs('reportes.lista') ? 'active' : '' }}" href="{{ route('reportes.lista') }}">
                            <i class="fas fa-list"></i> Lista General
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.aprobados') ? 'active' : '' }}" href="{{ route('reportes.aprobados') }}">
                            <i class="fas fa-chart-line"></i> Aprobados/Reprobados
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.estadisticas') ? 'active' : '' }}" href="{{ route('reportes.estadisticas') }}">
                            <i class="fas fa-chart-pie"></i> Estadísticas por Materia
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
                            <i class="fas fa-calculator"></i> Cantidad de Grupos Habilitados
                        </a>
                        <a class="nav-link" href="{{ route('bitacora.index') }}">
                            <i class="fas fa-history"></i> Bitácora
                        </a>
                        <a class="nav-link" href="{{ route('asistencias.index') }}">
                            <i class="fas fa-calendar-check"></i> Listado de Asistencias
                        </a>
                    @endif

                    <!-- SOLO COORDINADOR puede ver REPORTES (limitados) -->
                    @if(Auth::user()->isCoordinador())
                        <div class="text-white-50 small px-3 mt-3 mb-2">REPORTES</div>
                        <a class="nav-link {{ request()->routeIs('reportes.lista') ? 'active' : '' }}" href="{{ route('reportes.lista') }}">
                            <i class="fas fa-list"></i> Lista General
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.aprobados') ? 'active' : '' }}" href="{{ route('reportes.aprobados') }}">
                            <i class="fas fa-chart-line"></i> Aprobados/Reprobados
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.estadisticas') ? 'active' : '' }}" href="{{ route('reportes.estadisticas') }}">
                            <i class="fas fa-chart-pie"></i> Estadísticas por Materia
                        </a>
                        <a class="nav-link {{ request()->routeIs('reportes.promedios') ? 'active' : '' }}" href="{{ route('reportes.promedios') }}">
                            <i class="fas fa-calculator"></i> Promedios Generales
                        </a>
                    @endif

                    <!-- SOLO DOCENTE puede ver su módulo -->
                    @if(Auth::user()->isDocente())
                        <div class="text-white-50 small px-3 mt-3 mb-2">DOCENTE</div>
                        <a class="nav-link {{ request()->routeIs('docente.carga-horaria') ? 'active' : '' }}" href="{{ route('docente.carga-horaria') }}">
                            <i class="fas fa-clock"></i> Mi Carga Horaria
                        </a>
                        <a class="nav-link {{ request()->routeIs('asistencias.*') ? 'active' : '' }}" href="{{ route('asistencias.create') }}">
                            <i class="fas fa-check-circle"></i> Registrar Asistencia
                        </a>
                    @endif
                </nav>
            </div>
            <div class="col-md-9 col-lg-10 ms-sm-auto content-wrapper">
                <nav class="navbar-top d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 d-none d-md-block">@yield('header', 'Panel de Control')</h4>
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="badge ms-1" style="background: #0a2b5e;">Admin</span>
                                @elseif(Auth::user()->isDocente())
                                    <span class="badge bg-info ms-1">Docente</span>
                                @elseif(Auth::user()->isCoordinador())
                                    <span class="badge bg-warning ms-1">Coordinador</span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <main class="p-3 p-md-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @yield('content')
                </main>
                <footer>
                    <p class="mb-0">&copy; {{ date('Y') }} Sistema CUP FICCT - Facultad FICCT - UAGRM</p>
                </footer>
            </div>
            @endauth
            @guest
            <div class="col-12">@yield('content')</div>
            @endguest
        </div>
    </div>
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
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
    @stack('scripts')
</body>
</html>