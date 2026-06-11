<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Postulante;
use App\Models\Grupo;
use App\Models\Horario;

class PostulantePanelController extends Controller
{
    public function dashboard()
    {
        // Obtener el postulante asociado al usuario logueado
        $user = Auth::user();
        $postulante = Postulante::where('email', $user->email)->first();
        
        if (!$postulante) {
            return redirect()->route('dashboard')->with('error', 'No se encontraron datos de postulante asociados a tu cuenta.');
        }
        
        // Obtener el grupo del postulante
        $grupo = $postulante->grupo->first();
        
        // Obtener horarios si tiene grupo
        $horarios = [];
        if ($grupo) {
            $horarios = Horario::where('grupo_id', $grupo->id)
                ->with(['materia', 'aula', 'docente'])
                ->get();
        }
        
        return view('postulantes.dashboard', compact('postulante', 'grupo', 'horarios'));
    }
}