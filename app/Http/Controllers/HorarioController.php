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
        
        $error = $this->verificarConflictos($request);
        if ($error) {
            return back()->with('error', $error);
        }
        
        Horario::create($request->all());
        
        return redirect()->route('horarios.create')->with('success', '✅ Horario asignado exitosamente');
    }

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
        
        $error = $this->verificarConflictos($request, $horario->id);
        if ($error) {
            return back()->with('error', $error);
        }
        
        $horario->update($request->all());
        
        return redirect()->route('horarios.create')->with('success', '✅ Horario actualizado exitosamente');
    }

    /**
     * Lógica unificada para verificar conflictos de horario
     */
    private function verificarConflictos(Request $request, $excluirId = null)
    {
        $model = Horario::where('dia', $request->dia)
            ->where(function($q) use ($request) {
                $q->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                  ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('hora_inicio', '<=', $request->hora_inicio)
                         ->where('hora_fin', '>=', $request->hora_fin);
                  });
            });

        if ($excluirId) {
            $model->where('id', '!=', $excluirId);
        }

        // 1. Conflicto Docente
        if ((clone $model)->where('docente_id', $request->docente_id)->exists()) {
            return '❌ El docente ya tiene otra clase asignada en ese horario.';
        }

        // 2. Conflicto Grupo
        if ((clone $model)->where('grupo_id', $request->grupo_id)->exists()) {
            return '❌ El grupo ya tiene otra clase asignada en ese horario.';
        }

        // 3. Conflicto Aula
        if ((clone $model)->where('aula_id', $request->aula_id)->exists()) {
            return '❌ El aula ya está ocupada en ese horario.';
        }

        return null;
    }

    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.create')
            ->with('success', 'Horario eliminado exitosamente');
    }

    public function edit(Horario $horario)
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        $docentes = Docente::all();
        $aulas = Aula::all();
        
        return view('horarios.edit', compact('horario', 'grupos', 'materias', 'docentes', 'aulas'));
    }
}