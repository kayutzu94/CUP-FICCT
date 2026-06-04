<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Evaluacion;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\AsignacionDocente;

class ReporteController extends Controller
{
    // CU22: Reporte lista general de postulantes
    public function lista()
    {
        $postulantes = Postulante::with(['carreraAsignada', 'primeraCarrera', 'segundaCarrera'])->get();
        return view('reportes.lista', compact('postulantes'));
    }

    // CU23: Reporte de Aprobados y Reprobados
    public function aprobadosReprobados()
    {
        $aprobados = Postulante::where('estado_academico', 'aprobado')
            ->with('carreraAsignada')
            ->orderBy('promedio_final', 'desc')
            ->get();
        
        $reprobados = Postulante::where('estado_academico', 'reprobado')
            ->with('carreraAsignada')
            ->orderBy('promedio_final', 'desc')
            ->get();
        
        $totalAprobados = $aprobados->count();
        $totalReprobados = $reprobados->count();
        $totalPostulantes = Postulante::count();
        $tasaAprobacion = $totalPostulantes > 0 ? round(($totalAprobados / $totalPostulantes) * 100, 2) : 0;
        
        return view('reportes.aprobados', compact('aprobados', 'reprobados', 'totalAprobados', 'totalReprobados', 'tasaAprobacion'));
    }

    // CU24: Estadísticas por materia
    public function estadisticasMaterias()
    {
        $materias = Materia::all();
        $estadisticas = [];
        
        foreach ($materias as $materia) {
            $evaluaciones = Evaluacion::where('materia_id', $materia->id)
                ->whereNotNull('promedio')
                ->get();
            
            $total = $evaluaciones->count();
            $aprobados = $evaluaciones->where('estado', 'aprobado')->count();
            $reprobados = $evaluaciones->where('estado', 'reprobado')->count();
            
            $estadisticas[$materia->nombre] = [
                'promedio' => $total > 0 ? round($evaluaciones->avg('promedio'), 2) : 0,
                'maxima' => $total > 0 ? round($evaluaciones->max('promedio'), 2) : 0,
                'minima' => $total > 0 ? round($evaluaciones->min('promedio'), 2) : 0,
                'aprobados' => $aprobados,
                'reprobados' => $reprobados,
                'tasa_aprobacion' => $total > 0 ? round(($aprobados / $total) * 100, 2) : 0,
            ];
        }
        
        return view('reportes.estadisticas', compact('estadisticas'));
    }
}