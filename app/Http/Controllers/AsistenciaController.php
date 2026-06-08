<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Postulante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        
        // Admin y Coordinador pueden registrar asistencia también
        if ($user->isAdmin() || $user->isCoordinador()) {
            $grupos = \App\Models\Grupo::all();
            return view('asistencias.create', compact('grupos'));
        }
        
        // Para docentes, mostrar solo sus grupos
        if ($user->isDocente() && $user->docente_id) {
            $docente = $user->docente;
            $grupos = \App\Models\AsignacionDocente::where('docente_id', $docente->id)
                ->with('grupo')
                ->get()
                ->pluck('grupo');
            return view('asistencias.create', compact('grupos'));
        }
        
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para registrar asistencia.');
    }

    // Registrar asistencia
    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'fecha' => 'required|date',
            'asistencias' => 'array',
        ]);
        
        $grupo = \App\Models\Grupo::find($request->grupo_id);
        
        if (!$grupo) {
            return redirect()->route('asistencias.create')->with('error', 'Grupo no encontrado');
        }
        
        foreach ($grupo->postulantes as $postulante) {
            $presente = isset($request->asistencias[$postulante->id]) ? 1 : 0;
            
            \App\Models\Asistencia::updateOrCreate(
                [
                    'postulante_id' => $postulante->id,
                    'grupo_id' => $grupo->id,
                    'fecha' => $request->fecha,
                ],
                ['presente' => $presente]
            );
        }
        
        return redirect()->route('asistencias.create')
            ->with('success', 'Asistencia registrada exitosamente para ' . $grupo->postulantes->count() . ' estudiantes');
    }
}