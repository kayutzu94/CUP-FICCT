<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Aula;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // CU17: Asignar horario, aula y materia
    public function create()
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        $docentes = Docente::all();
        $aulas = Aula::all();
        
        return view('horarios.create', compact('grupos', 'materias', 'docentes', 'aulas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'materia_id' => 'required|exists:materias,id',
            'docente_id' => 'required|exists:docentes,id',
            'aula_id' => 'required|exists:aulas,id',
            'dia' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);
        
        // Verificar conflicto de aula
        $conflicto = Horario::where('aula_id', $request->aula_id)
            ->where('dia', $request->dia)
            ->where(function($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                  ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })->exists();
            
        if ($conflicto) {
            return back()->with('error', 'El aula ya está ocupada en ese horario');
        }
        
        Horario::create($request->all());
        
        return redirect()->route('horarios.create')->with('success', 'Horario asignado exitosamente');
    }
}