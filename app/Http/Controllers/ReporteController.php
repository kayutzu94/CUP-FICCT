<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Models\Evaluacion;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Carrera;
use App\Models\AsignacionDocente;

class ReporteController extends Controller
{
    // CU22: Reporte lista general de postulantes (Mejorado con filtros robustos y avanzados)
    public function lista(Request $request)
    {
        // Query base: solo aprobados
        $query = Postulante::where('estado_academico', 'aprobado')
            ->with(['primeraCarrera', 'segundaCarrera', 'carreraAsignada']);
                
        // FILTRO 1: Por tipo de asignación (primera opción, segunda opción, lista espera)
        if ($request->filled('tipo_asignacion')) {
            switch ($request->tipo_asignacion) {
                case 'primera':
                    $query->whereNotNull('carrera_asignada_id')
                          ->whereRaw('carrera_asignada_id = primera_carrera_id');
                    break;
                                    
                case 'segunda':
                    $query->whereNotNull('carrera_asignada_id')
                          ->whereRaw('carrera_asignada_id = segunda_carrera_id');
                    break;
                                    
                case 'lista_espera':
                    $query->whereNull('carrera_asignada_id');
                    break;
            }
        }
                
        // FILTRO 2: Por carrera específica
        if ($request->filled('carrera_id')) {
            $query->where('carrera_asignada_id', $request->carrera_id);
        }
                
        // FILTRO 3: Búsqueda por nombre, CI, email o nombre completo concatenado
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombres', 'LIKE', "%{$search}%")
                  ->orWhere('apellidos', 'LIKE', "%{$search}%")
                  ->orWhere('ci', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$search}%"]);
            });
        }

        // FILTRO 4: Promedio mínimo
        if ($request->filled('promedio_min')) {
            $query->where('promedio_final', '>=', $request->promedio_min);
        }

        // FILTRO 5: Promedio máximo
        if ($request->filled('promedio_max')) {
            $query->where('promedio_final', '<=', $request->promedio_max);
        }

        // FILTRO 6: Sexo
        if ($request->filled('sexo')) {
            $query->where('sexo', $request->sexo);
        }

        // FILTRO 7: Ciudad
        if ($request->filled('ciudad')) {
            $query->where('ciudad', 'LIKE', "%{$request->ciudad}%");
        }
                
        // Ordenar por promedio (mejores primero)
        $query->orderBy('promedio_final', 'desc');
                
        // Paginar resultados manteniendo los parámetros de búsqueda en la URL
        $postulantes = $query->paginate(20);
                
        // ESTADÍSTICAS globales fijas (no se ven afectadas por los filtros)
        $totalAprobados = Postulante::where('estado_academico', 'aprobado')->count();
                
        $primeraOpcion = Postulante::where('estado_academico', 'aprobado')
                                   ->whereNotNull('carrera_asignada_id')
                                   ->whereRaw('carrera_asignada_id = primera_carrera_id')
                                   ->count();
                                           
        $segundaOpcion = Postulante::where('estado_academico', 'aprobado')
                                   ->whereNotNull('carrera_asignada_id')
                                   ->whereRaw('carrera_asignada_id = segunda_carrera_id')
                                   ->count();
                                           
        $listaEspera = Postulante::where('estado_academico', 'aprobado')
                                 ->whereNull('carrera_asignada_id')
                                 ->count();
                
        $carreras = Carrera::orderBy('nombre')->get();
                
        return view('reportes.lista', compact(
            'postulantes',
            'totalAprobados',
            'primeraOpcion',
            'segundaOpcion',
            'listaEspera',
            'carreras'
        ));
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
        // Obtener todas las asignaciones con sus relaciones
        $asignaciones = AsignacionDocente::with(['docente', 'grupo', 'materia'])
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        
        // También agrupar por grupo para vista alternativa
        $asignacionesPorGrupo = $asignaciones->groupBy('grupo_id');
        
        // Depuración: Verificar si hay datos
        \Log::info('Asignaciones encontradas: ' . $asignaciones->count());
        
        return view('reportes.docentes_por_grupos', compact('asignaciones', 'asignacionesPorGrupo'));
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

    // Reporte de Cantidad de Grupos Habilitados
    public function gruposHabilitados()
    {
        $totalInscritos = Postulante::count();
        $totalGrupos = Grupo::count();
        $capacidadPorGrupo = 70;
        $gruposNecesarios = ceil($totalInscritos / $capacidadPorGrupo);
        $capacidadTotal = $totalGrupos * $capacidadPorGrupo;
        $capacidadUtilizada = $totalInscritos;
        $capacidadLibre = $capacidadTotal - $capacidadUtilizada;
        
        $grupos = Grupo::withCount('postulantes')->get();
        
        return view('reportes.grupos_habilitados', compact(
            'totalInscritos', 
            'totalGrupos', 
            'gruposNecesarios',
            'capacidadTotal',
            'capacidadUtilizada',
            'capacidadLibre',
            'grupos'
        ));
    }
}