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
}