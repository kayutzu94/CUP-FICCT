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
use Illuminate\Support\Facades\Route;

// ============================================
// RUTAS PÚBLICAS
// ============================================

// Redirige la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (Breeze) - incluye login, registro, recuperación
require __DIR__.'/auth.php';

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
    // La ruta de búsqueda debe ir ANTES del resource
    Route::get('/postulantes/search', [PostulanteController::class, 'search'])->name('postulantes.search');
    Route::resource('postulantes', PostulanteController::class);
    
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
    
    // ============================================
    // CARGA HORARIA (solo para docentes)
    // ============================================
    Route::get('/docente/carga-horaria', [DocenteController::class, 'cargaHoraria'])->name('docente.carga-horaria');
    
    // ============================================
    // HORARIOS - CREAR, LISTAR , ELIMINAR y EDITAR HORARIOS ASIGNADOS
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
    Route::get('/asistencias', [App\Http\Controllers\AsistenciaListadoController::class, 'index'])->name('asistencias.index');
    
    // ============================================
    // EVALUACIONES - NOTAS POR MATERIA
    // ============================================
    Route::get('/postulantes/{postulante}/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::get('/postulantes/{postulante}/materias/{materia}/evaluaciones/edit', [EvaluacionController::class, 'edit'])->name('evaluaciones.edit');
    Route::put('/postulantes/{postulante}/materias/{materia}/evaluaciones', [EvaluacionController::class, 'update'])->name('evaluaciones.update');
    
    // ============================================
    // REPORTES
    // ============================================
    // Reportes básicos
    Route::get('/reportes/lista', [ReporteController::class, 'lista'])->name('reportes.lista');
    Route::get('/reportes/aprobados', [ReporteController::class, 'aprobadosReprobados'])->name('reportes.aprobados');
    Route::get('/reportes/estadisticas', [ReporteController::class, 'estadisticasMaterias'])->name('reportes.estadisticas');
    
    // Reportes adicionales
    Route::get('/reportes/promedios', [ReporteController::class, 'promediosGenerales'])->name('reportes.promedios');
    Route::get('/reportes/docentes-por-grupos', [ReporteController::class, 'docentesPorGrupos'])->name('reportes.docentes-por-grupos');
    Route::get('/reportes/grupos-mas-aprobados', [ReporteController::class, 'gruposMasAprobados'])->name('reportes.grupos-mas-aprobados');
    Route::get('/reportes/grupos-habilitados', [ReporteController::class, 'gruposHabilitados'])->name('reportes.grupos-habilitados');
    
    // ============================================
    // IMPORTACIÓN DE DATOS
    // ============================================
    // Importación de postulantes (CSV/Excel)
    Route::get('/importacion', [ImportController::class, 'index'])->name('importacion.index');
    Route::post('/importacion', [ImportController::class, 'import'])->name('importacion.import');
    
    // Importación de usuarios (docentes/coordinadores)
    Route::get('/importacion/usuarios', [ImportController::class, 'usuarios'])->name('importacion.usuarios');
    Route::post('/importacion/usuarios', [ImportController::class, 'importUsers'])->name('importacion.usuarios.import');
    Route::get('/importacion/plantilla-usuarios', [ImportController::class, 'plantillaUsuarios'])->name('importacion.plantilla-usuarios');
    
    // ============================================
    // EXPORTACIÓN DE DATOS
    // ============================================
    Route::get('/exportar/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/exportar/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');
    
    // Vista de exportación (menú)
    Route::get('/exportacion', function () {
        return view('exportacion.index');
    })->name('exportacion.index');
    
    // ============================================
    // API PARA ASISTENCIAS (cargar estudiantes por grupo)
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
});