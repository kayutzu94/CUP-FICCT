<?php

use App\Http\Controllers\PostulanteController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AsignacionCuposController;
use App\Http\Controllers\AsignacionCarrerasController;
use App\Http\Controllers\AsignacionDocenteController;
use App\Http\Controllers\PostulantePanelController;
use App\Http\Controllers\AsistenciaListadoController;
use App\Http\Controllers\VoiceCommandController;
use App\Http\Controllers\BitacoraController;
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Redirige la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta POST para restablecer contraseña (solución temporal)
Route::post('/reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update.post');

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registrar usuario (opcional, mantener Breeze)
Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// Recuperar contraseña
Route::get('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');

// ============================================
// RUTAS PROTEGIDAS (requieren autenticación)
// ============================================
Route::middleware(['auth'])->group(function () {
    
    // ============================================
    // DASHBOARD
    // ============================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ============================================
    // POSTULANTES - CRUD + BÚSQUEDA
    // ============================================
    Route::get('/postulantes/search', [PostulanteController::class, 'search'])->name('postulantes.search');
    Route::resource('postulantes', PostulanteController::class);

    // ============================================
    // POSTULANTE PANEL (dashboard para postulantes)
    // ============================================
    Route::get('/postulante/dashboard', [PostulantePanelController::class, 'dashboard'])->name('postulante.dashboard');
    
    // ============================================
    // GRUPOS - CRUD + ASIGNACIÓN AUTOMÁTICA
    // ============================================
    Route::resource('grupos', GrupoController::class);
    Route::post('/grupos/asignar-automatico', [GrupoController::class, 'asignarAutomatico'])->name('grupos.asignar-automatico');
    
    // ============================================
    // DOCENTES - CRUD + ASIGNACIÓN A GRUPOS
    // ============================================
    Route::resource('docentes', DocenteController::class);
    Route::post('/docentes/{docente}/asignar-grupos', [DocenteController::class, 'asignarGrupos'])->name('docentes.asignar-grupos');
    
    // Ruta para eliminar asignación docente-grupo
    Route::delete('/asignaciones/{asignacion}', [AsignacionDocenteController::class, 'destroy'])->name('asignaciones.destroy');
    
    // ============================================
    // CARGA HORARIA (solo para docentes)
    // ============================================
    Route::get('/docente/carga-horaria', [DocenteController::class, 'cargaHoraria'])->name('docente.carga-horaria');
    
    // ============================================
    // HORARIOS - CREAR, LISTAR, ELIMINAR y EDITAR
    // ============================================
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');
    Route::get('/horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    
    // ============================================
    // ASISTENCIAS - REGISTRAR
    // ============================================
    Route::get('/asistencias/create', [AsistenciaController::class, 'create'])->name('asistencias.create');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias', [AsistenciaListadoController::class, 'index'])->name('asistencias.index');
    
    // ============================================
    // EVALUACIONES - NOTAS POR MATERIA
    // ============================================
    Route::get('/postulantes/{postulante}/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::get('/postulantes/{postulante}/materias/{materia}/evaluaciones/edit', [EvaluacionController::class, 'edit'])->name('evaluaciones.edit');
    Route::put('/postulantes/{postulante}/materias/{materia}/evaluaciones', [EvaluacionController::class, 'update'])->name('evaluaciones.update');
    
    // ============================================
    // REPORTES
    // ============================================
    Route::get('/reportes/lista', [ReporteController::class, 'lista'])->name('reportes.lista');
    Route::get('/reportes/aprobados', [ReporteController::class, 'aprobadosReprobados'])->name('reportes.aprobados');
    Route::get('/reportes/estadisticas', [ReporteController::class, 'estadisticasMaterias'])->name('reportes.estadisticas');
    Route::get('/reportes/promedios', [ReporteController::class, 'promediosGenerales'])->name('reportes.promedios');
    Route::get('/reportes/docentes-por-grupos', [ReporteController::class, 'docentesPorGrupos'])->name('reportes.docentes-por-grupos');
    Route::get('/reportes/grupos-mas-aprobados', [ReporteController::class, 'gruposMasAprobados'])->name('reportes.grupos-mas-aprobados');
    Route::get('/reportes/grupos-habilitados', [ReporteController::class, 'gruposHabilitados'])->name('reportes.grupos-habilitados');
    
    // ============================================
    // CUPOS POR CARRERA - ASIGNACIÓN AUTOMÁTICA
    // ============================================
    Route::get('/cupos', [AsignacionCuposController::class, 'index'])->name('cupos.index');
    Route::post('/cupos/asignar', [AsignacionCuposController::class, 'ejecutarAsignacion'])->name('cupo.asignar');
    // Dentro del grupo auth
    Route::put('/cupos/{carrera}', [AsignacionCuposController::class, 'update'])->name('cupo.update');
    
    // ============================================
    // ASIGNACIÓN AUTOMÁTICA DE CARRERAS POR MÉRITO
    // ============================================
    Route::get('/asignacion', [AsignacionCarrerasController::class, 'index'])->name('asignacion.index');
    Route::post('/asignacion/ejecutar', [AsignacionCarrerasController::class, 'asignar'])->name('asignacion.ejecutar');
    
    // ============================================
    // IMPORTACIÓN DE DATOS
    // ============================================
    Route::get('/importacion', [ImportController::class, 'index'])->name('importacion.index');
    Route::post('/importacion', [ImportController::class, 'import'])->name('importacion.import');
    Route::get('/importacion/usuarios', [ImportController::class, 'usuarios'])->name('importacion.usuarios');
    Route::post('/importacion/usuarios', [ImportController::class, 'importUsers'])->name('importacion.usuarios.import');
    Route::get('/importacion/plantilla-usuarios', [ImportController::class, 'plantillaUsuarios'])->name('importacion.plantilla-usuarios');
    
    // ============================================
    // EXPORTACIÓN DE DATOS
    // ============================================
    Route::get('/exportar/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/exportar/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/exportacion', function () {
        return view('exportacion.index');
    })->name('exportacion.index');
    
    // ============================================
    // API PARA ASISTENCIAS
    // ============================================
    Route::get('/api/grupos/{grupo}/estudiantes', function($grupoId) {
        $grupo = \App\Models\Grupo::with('postulantes.carreraAsignada')->find($grupoId);
        return response()->json($grupo->postulantes ?? []);
    });
    
    // ============================================
    // PAYPAL - PASARELA DE PAGOS
    // ============================================
    Route::get('/paypal/create', [App\Http\Controllers\PayPalController::class, 'createOrder'])->name('paypal.create');
    Route::get('/paypal/capture', [App\Http\Controllers\PayPalController::class, 'captureOrder'])->name('paypal.capture');
    Route::get('/paypal/cancel', [App\Http\Controllers\PayPalController::class, 'cancelOrder'])->name('paypal.cancel');

    // ============================================
    // ASISTENTE DE VOZ
    // ============================================
    Route::post('/voice-command', [VoiceCommandController::class, 'handle'])->name('voice.command');

    // ============================================
    // BITÁCORA
    // ============================================
    Route::get('/bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');
    Route::delete('/bitacora', [BitacoraController::class, 'limpiar'])->name('bitacora.limpiar');
   
});