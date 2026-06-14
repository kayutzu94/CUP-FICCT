<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Postulante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsignacionCuposController extends Controller
{
    /**
     * Muestra el panel de gestión de cupos y estadísticas.
     */
    public function index()
    {
        $carreras = Carrera::withCount(['postulantesAsignados' => function($q) {
            $q->where('estado_academico', 'aprobado');
        }])->get();
        
        $totalAprobados = Postulante::where('estado_academico', 'aprobado')->count();
        $totalAsignados = Postulante::where('estado_academico', 'aprobado')
                                    ->whereNotNull('carrera_asignada_id')
                                    ->count();
        $totalEspera = Postulante::where('estado_academico', 'aprobado')
                                 ->whereNull('carrera_asignada_id')
                                 ->count();
        
        return view('asignacion.cupos', compact('carreras', 'totalAprobados', 'totalAsignados', 'totalEspera'));
    }
    
    /**
     * Actualiza el cupo de una carrera específica.
     */
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'cupo' => 'required|integer|min:0|max:200'
        ]);
        
        $carrera->cupo = $request->cupo;
        $carrera->save();
        
        return redirect()->route('cupos.index')
            ->with('success', "✅ Cupo actualizado: {$carrera->nombre} ahora tiene {$request->cupo} plazas disponibles.");
    }
    
    /**
     * Ejecuta el algoritmo de asignación automática basada en promedios (mérito).
     */
   public function ejecutarAsignacion(Request $request)
    {
        try {
            // 1. Obtener cupos
            $carreras = Carrera::all();
            $cupos = [];
            foreach ($carreras as $carrera) {
                $cupos[$carrera->id] = $carrera->cupo ?? 0;
            }
            
            // 2. Resetear asignaciones
            Postulante::where('estado_academico', 'aprobado')
                    ->update(['carrera_asignada_id' => null]);
            
            // 3. Obtener postulantes ordenados por mérito
            $postulantes = Postulante::where('estado_academico', 'aprobado')
                ->orderBy('promedio_final', 'desc')
                ->get();
            
            if ($postulantes->isEmpty()) {
                return redirect()->route('cupos.index')->with('error', 'No hay postulantes aprobados');
            }
            
            // 4. Asignar
            $asignados = [];
            foreach ($cupos as $id => $cupo) {
                $asignados[$id] = 0;
            }
            
            $totalAsignados = 0;
            
            foreach ($postulantes as $postulante) {
                // Primera opción
                if ($asignados[$postulante->primera_carrera_id] < $cupos[$postulante->primera_carrera_id]) {
                    $postulante->carrera_asignada_id = $postulante->primera_carrera_id;
                    $asignados[$postulante->primera_carrera_id]++;
                    $postulante->save();
                    $totalAsignados++;
                }
                // Segunda opción
                elseif ($postulante->segunda_carrera_id && 
                        $asignados[$postulante->segunda_carrera_id] < $cupos[$postulante->segunda_carrera_id]) {
                    $postulante->carrera_asignada_id = $postulante->segunda_carrera_id;
                    $asignados[$postulante->segunda_carrera_id]++;
                    $postulante->save();
                    $totalAsignados++;
                }
            }
            
            $enEspera = $postulantes->count() - $totalAsignados;
            
            return redirect()->route('cupos.index')
                ->with('success', "✅ Asignación completada: {$totalAsignados} asignados, {$enEspera} en lista de espera.");
                
        } catch (\Exception $e) {
            return redirect()->route('cupos.index')
                ->with('error', "❌ Error: " . $e->getMessage());
        }
    }
}