<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Carrera;
use App\Models\Evaluacion;
use App\Models\Materia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs principales
        $totalInscritos = Postulante::count();
        $totalAprobados = Postulante::where('estado_academico', 'aprobado')->count();
        $totalReprobados = Postulante::where('estado_academico', 'reprobado')->count();
        $totalGrupos = Grupo::count();
        $totalDocentes = Docente::count();
        $totalCarreras = Carrera::count();
        $gruposNecesarios = $totalInscritos > 0 ? ceil($totalInscritos / 70) : 0;
        
        // Datos para gráfico de barras - Rendimiento por materia
        $estadisticasMaterias = Evaluacion::select(
                'materias.nombre',
                DB::raw('COALESCE(AVG(evaluaciones.promedio), 0) as promedio')
            )
            ->join('materias', 'evaluaciones.materia_id', '=', 'materias.id')
            ->groupBy('materias.id', 'materias.nombre')
            ->get();
        
        // Datos para gráfico de torta - Distribución de estados
        $aprobados = Postulante::where('estado_academico', 'aprobado')->count();
        $reprobados = Postulante::where('estado_academico', 'reprobado')->count();
        $pendientes = Postulante::where('estado_academico', 'inscrito')->count();
        
        // Datos para gráfico de líneas - Evolución de inscripciones (últimos 30 días)
        $evolucion = Postulante::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
        
        // Datos para gráfico de grupos
        $gruposData = Grupo::withCount('postulantes')->get();
        
        return view('dashboard', compact(
            'totalInscritos', 'totalAprobados', 'totalReprobados',
            'totalGrupos', 'totalDocentes', 'totalCarreras',
            'gruposNecesarios', 'estadisticasMaterias',
            'aprobados', 'reprobados', 'pendientes', 'evolucion', 'gruposData'
        ));
    }
}