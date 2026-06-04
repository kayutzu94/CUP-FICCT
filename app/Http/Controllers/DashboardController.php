<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Carrera;
use App\Models\Evaluacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        
        // Calcular grupos necesarios
        $gruposNecesarios = $totalInscritos > 0 ? ceil($totalInscritos / 70) : 0;
        
        // Estadísticas por materia
        $estadisticasMaterias = Evaluacion::select(
                'materias.nombre',
                DB::raw('COALESCE(AVG(evaluaciones.promedio), 0) as promedio'),
                DB::raw('COUNT(CASE WHEN evaluaciones.promedio >= 60 THEN 1 END) as aprobados'),
                DB::raw('COUNT(CASE WHEN evaluaciones.promedio < 60 THEN 1 END) as reprobados')
            )
            ->join('materias', 'evaluaciones.materia_id', '=', 'materias.id')
            ->groupBy('materias.id', 'materias.nombre')
            ->get();
        
        // Pasar todas las variables a la vista
        return view('dashboard', [
            'totalInscritos' => $totalInscritos,
            'totalAprobados' => $totalAprobados,
            'totalReprobados' => $totalReprobados,
            'totalGrupos' => $totalGrupos,
            'totalDocentes' => $totalDocentes,
            'totalCarreras' => $totalCarreras,
            'gruposNecesarios' => $gruposNecesarios,
            'estadisticasMaterias' => $estadisticasMaterias
        ]);
    }
}