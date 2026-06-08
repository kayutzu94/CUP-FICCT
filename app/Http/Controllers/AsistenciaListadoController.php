<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaListadoController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with(['postulante', 'grupo'])
            ->orderBy('fecha', 'desc')
            ->orderBy('grupo_id')
            ->get();
        
        return view('asistencias.index', compact('asistencias'));
    }
}