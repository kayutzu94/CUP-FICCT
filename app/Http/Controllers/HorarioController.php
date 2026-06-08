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

    //Eliminar horario asignado
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.create')
            ->with('success', 'Horario eliminado exitosamente');
    }

    // Mostrar formulario de edición
    public function edit(Horario $horario)
    {
        $grupos = \App\Models\Grupo::all();
        $materias = \App\Models\Materia::all();
        $docentes = \App\Models\Docente::all();
        $aulas = \App\Models\Aula::all();
        
        return view('horarios.edit', compact('horario', 'grupos', 'materias', 'docentes', 'aulas'));
    }

    // Actualizar horario
    public function update(Request $request, Horario $horario)
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
        
        // Verificar conflicto de aula (excluyendo el horario actual)
        $conflicto = \App\Models\Horario::where('aula_id', $request->aula_id)
            ->where('dia', $request->dia)
            ->where('id', '!=', $horario->id)
            ->where(function($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })->exists();
            
        if ($conflicto) {
            return back()->with('error', 'El aula ya está ocupada en ese horario');
        }
        
        $horario->update($request->all());
        
        return redirect()->route('horarios.create')->with('success', 'Horario actualizado');
    }
}