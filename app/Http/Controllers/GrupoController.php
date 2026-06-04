<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Postulante;
use App\Models\AsignacionGrupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::all();
        $totalInscritos = Postulante::count();
        
        // CU14: Calcular cantidad de grupos automáticamente
        // Fórmula: CantidadGrupos = CEIL(TotalInscritos / 70)
        $gruposNecesarios = $this->calcularGruposNecesarios($totalInscritos);
        
        return view('grupos.index', compact('grupos', 'totalInscritos', 'gruposNecesarios'));
    }

    // CU14: Calcular grupos
    private function calcularGruposNecesarios($totalInscritos)
    {
        if ($totalInscritos == 0) return 0;
        return (int) ceil($totalInscritos / 70);
    }

    // CU15: Asignar estudiantes automáticamente a grupos
    public function asignarAutomatico(Request $request)
    {
        // Limpiar asignaciones existentes
        AsignacionGrupo::truncate();
        Grupo::query()->update(['estudiantes_actuales' => 0]);
        
        $postulantes = Postulante::all();
        $grupos = Grupo::where('capacidad_maxima', 70)->get();
        
        if ($grupos->isEmpty()) {
            return redirect()->route('grupos.index')
                ->with('error', 'No hay grupos disponibles. Cree grupos primero.');
        }
        
        $grupoIndex = 0;
        $totalGrupos = $grupos->count();
        
        foreach ($postulantes as $postulante) {
            // Buscar grupo con cupo disponible
            $asignado = false;
            for ($i = 0; $i < $totalGrupos; $i++) {
                $grupoActual = $grupos[$grupoIndex];
                if ($grupoActual->estudiantes_actuales < $grupoActual->capacidad_maxima) {
                    AsignacionGrupo::create([
                        'postulante_id' => $postulante->id,
                        'grupo_id' => $grupoActual->id,
                        'fecha_asignacion' => now(),
                    ]);
                    $grupoActual->increment('estudiantes_actuales');
                    $asignado = true;
                    $grupoIndex = ($grupoIndex + 1) % $totalGrupos;
                    break;
                }
                $grupoIndex = ($grupoIndex + 1) % $totalGrupos;
            }
            
            if (!$asignado) {
                $grupoIndex = 0;
                $grupoActual = $grupos[$grupoIndex];
                AsignacionGrupo::create([
                    'postulante_id' => $postulante->id,
                    'grupo_id' => $grupoActual->id,
                    'fecha_asignacion' => now(),
                ]);
                $grupoActual->increment('estudiantes_actuales');
                $grupoIndex = ($grupoIndex + 1) % $totalGrupos;
            }
        }
        
        return redirect()->route('grupos.index')
            ->with('success', 'Asignación automática completada exitosamente');
    }

    // CU18: Ver estudiantes por grupo
    public function show(Grupo $grupo)
    {
        $grupo->load('postulantes');
        return view('grupos.show', compact('grupo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:grupos',
            'nombre' => 'required',
        ]);

        Grupo::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'capacidad_maxima' => 70,
            'estudiantes_actuales' => 0,
        ]);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado');
    }
}