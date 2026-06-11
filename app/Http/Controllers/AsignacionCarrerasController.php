<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulante;
use App\Models\Carrera;

class AsignacionCarrerasController extends Controller
{
    public function index()
    {
        $totalAprobados = Postulante::where('estado_academico', 'aprobado')->count();
        $carreras = Carrera::all();
        
        return view('asignacion.index', compact('totalAprobados', 'carreras'));
    }
    
    public function asignar(Request $request)
    {
        $request->validate([
            'cupos_primera_opcion' => 'required|integer|min:1|max:500'
        ]);
        
        $cuposPrimeraOpcion = $request->cupos_primera_opcion;
        
        // Resetear contadores
        Carrera::query()->update(['inscritos_actuales' => 0]);
        
        // Obtener postulantes aprobados ordenados por promedio
        $postulantes = Postulante::where('estado_academico', 'aprobado')
            ->orderBy('promedio_final', 'desc')
            ->get();
        
        $asignadosPrimera = 0;
        $asignadosSegunda = 0;
        $sinCupo = 0;
        
        foreach ($postulantes as $index => $postulante) {
            $primera = Carrera::find($postulante->primera_carrera_id);
            $segunda = Carrera::find($postulante->segunda_carrera_id);
            
            $asignado = false;
            
            if ($index < $cuposPrimeraOpcion) {
                if ($primera && $primera->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $primera->id;
                    $primera->increment('inscritos_actuales');
                    $asignadosPrimera++;
                    $asignado = true;
                } elseif ($segunda && $segunda->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $segunda->id;
                    $segunda->increment('inscritos_actuales');
                    $asignadosSegunda++;
                    $asignado = true;
                }
            } else {
                if ($segunda && $segunda->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $segunda->id;
                    $segunda->increment('inscritos_actuales');
                    $asignadosSegunda++;
                    $asignado = true;
                } elseif ($primera && $primera->tieneCupoDisponible()) {
                    $postulante->carrera_asignada_id = $primera->id;
                    $primera->increment('inscritos_actuales');
                    $asignadosPrimera++;
                    $asignado = true;
                }
            }
            
            if (!$asignado) {
                $postulante->carrera_asignada_id = null;
                $sinCupo++;
            }
            
            $postulante->save();
        }
        
        return redirect()->route('postulantes.index')->with('success', 
            "✅ Asignación completada: {$asignadosPrimera} a primera opción, {$asignadosSegunda} a segunda opción. {$sinCupo} quedaron en lista de espera."
        );
    }
}