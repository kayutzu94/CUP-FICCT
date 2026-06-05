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
    // CU28: Reporte de Promedios Generales
    public function promediosGenerales()
    {
        $postulantes = Postulante::with(['carreraAsignada'])
            ->orderBy('promedio_final', 'desc')
            ->get();
        
        $promedioGeneral = $postulantes->avg('promedio_final') ?? 0;
        $totalAprobados = $postulantes->where('estado_academico', 'aprobado')->count();
        $totalReprobados = $postulantes->where('estado_academico', 'reprobado')->count();
        
        return view('reportes.promedios', compact('postulantes', 'promedioGeneral', 'totalAprobados', 'totalReprobados'));
    }
    // CU29: Reporte de Docentes por Grupos
    public function docentesPorGrupos()
    {
        $grupos = Grupo::with(['aula', 'docentesAsignados'])->get();
        
        return view('reportes.docentes_por_grupos', compact('grupos'));
    }
    // CU30: Reporte de Grupos con mayor cantidad de aprobados
    public function gruposMasAprobados()
    {
        $grupos = Grupo::withCount(['postulantes as total_estudiantes'])
            ->withCount(['postulantes as aprobados' => function($query) {
                $query->where('estado_academico', 'aprobado');
            }])
            ->withCount(['postulantes as reprobados' => function($query) {
                $query->where('estado_academico', 'reprobado');
            }])
            ->orderBy('aprobados', 'desc')
            ->get();
        
        foreach($grupos as $grupo) {
            $grupo->tasa_aprobacion = $grupo->total_estudiantes > 0 
                ? round(($grupo->aprobados / $grupo->total_estudiantes) * 100, 2) 
                : 0;
        }
        
        return view('reportes.grupos_mas_aprobados', compact('grupos'));
    }
}