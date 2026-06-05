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

// Ruta de bienvenida redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard - USANDO TU CONTROLADOR
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Postulantes
    Route::resource('postulantes', PostulanteController::class);
    Route::get('/postulantes/search', [PostulanteController::class, 'search'])->name('postulantes.search');
    
    // Grupos
    Route::resource('grupos', GrupoController::class);
    Route::post('/grupos/asignar-automatico', [GrupoController::class, 'asignarAutomatico'])->name('grupos.asignar-automatico');
    
    // Docentes
    Route::resource('docentes', DocenteController::class);
    Route::post('/docentes/{docente}/asignar-grupos', [DocenteController::class, 'asignarGrupos'])->name('docentes.asignar-grupos');
    
    // Carga horaria docente
    Route::get('/docente/carga-horaria', [DocenteController::class, 'cargaHoraria'])->name('docente.carga-horaria');
    
    // Horarios
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    
    // Asistencias
    Route::get('/asistencias/create', [AsistenciaController::class, 'create'])->name('asistencias.create');
    Route::post('/asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    
    // Evaluaciones
    Route::get('/postulantes/{postulante}/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::get('/postulantes/{postulante}/materias/{materia}/evaluaciones/edit', [EvaluacionController::class, 'edit'])->name('evaluaciones.edit');
    Route::put('/postulantes/{postulante}/materias/{materia}/evaluaciones', [EvaluacionController::class, 'update'])->name('evaluaciones.update');
    
    // Reportes
    Route::get('/reportes/lista', [ReporteController::class, 'lista'])->name('reportes.lista');
    Route::get('/reportes/aprobados', [ReporteController::class, 'aprobadosReprobados'])->name('reportes.aprobados');
    Route::get('/reportes/estadisticas', [ReporteController::class, 'estadisticasMaterias'])->name('reportes.estadisticas');
    
    // Importación
    Route::get('/importacion', [ImportController::class, 'index'])->name('importacion.index');
    Route::post('/importacion', [ImportController::class, 'import'])->name('importacion.import');
    
    // Exportación
    Route::get('/exportar/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/exportar/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/exportacion', function () {
        return view('exportacion.index');
    })->name('exportacion.index');
    
    // API para asistencias
    Route::get('/api/grupos/{grupo}/estudiantes', function($grupoId) {
        $grupo = \App\Models\Grupo::with('postulantes.carreraAsignada')->find($grupoId);
        return response()->json($grupo->postulantes ?? []);
    });

    // Reportes
    Route::get('/reportes/promedios', [ReporteController::class, 'promediosGenerales'])->name('reportes.promedios');
    Route::get('/reportes/docentes-por-grupos', [ReporteController::class, 'docentesPorGrupos'])->name('reportes.docentes-por-grupos');
    Route::get('/reportes/grupos-mas-aprobados', [ReporteController::class, 'gruposMasAprobados'])->name('reportes.grupos-mas-aprobados');

    Route::get('/reportes/grupos-habilitados', [ReporteController::class, 'gruposHabilitados'])->name('reportes.grupos-habilitados');
});