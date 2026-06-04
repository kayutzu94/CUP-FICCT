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
        
        if (!$user->isDocente() || !$user->docente_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes perfil de docente');
        }
        
        $docente = $user->docente;
        $grupos = \App\Models\AsignacionDocente::where('docente_id', $docente->id)
            ->with('grupo')
            ->get()
            ->pluck('grupo');
        
        return view('asistencias.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'fecha' => 'required|date',
            'asistencias' => 'array',
        ]);
        
        $grupo = Grupo::find($request->grupo_id);
        
        foreach ($grupo->postulantes as $postulante) {
            $presente = isset($request->asistencias[$postulante->id]) ? 1 : 0;
            
            Asistencia::updateOrCreate(
                [
                    'postulante_id' => $postulante->id,
                    'grupo_id' => $grupo->id,
                    'fecha' => $request->fecha,
                ],
                ['presente' => $presente]
            );
        }
        
        return redirect()->route('asistencias.create')->with('success', 'Asistencia registrada');
    }
}