<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Postulante;
use App\Models\Materia;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index(Postulante $postulante)
    {
        $evaluaciones = $postulante->evaluaciones()->with('materia')->get();
        return view('evaluaciones.index', compact('postulante', 'evaluaciones'));
    }

    // CU9: Registrar Notas por Materia / CU10: Editar Notas
    public function edit(Postulante $postulante, Materia $materia)
    {
        $evaluacion = Evaluacion::where('postulante_id', $postulante->id)
            ->where('materia_id', $materia->id)
            ->firstOrFail();
        
        return view('evaluaciones.edit', compact('postulante', 'materia', 'evaluacion'));
    }

    // CU9, CU10, CU11, CU12: Guardar notas, calcular promedio, determinar estado
    public function update(Request $request, Postulante $postulante, Materia $materia)
    {
        $validated = $request->validate([
            'examen1' => 'nullable|numeric|min:0|max:100',
            'examen2' => 'nullable|numeric|min:0|max:100',
            'examen3' => 'nullable|numeric|min:0|max:100',
        ]);

        $evaluacion = Evaluacion::where('postulante_id', $postulante->id)
            ->where('materia_id', $materia->id)
            ->firstOrFail();

        $evaluacion->update($validated);
        
        // CU11: Calcular promedio (N1+N2+N3)/3
        $promedioMateria = $evaluacion->calcularPromedio();
        
        // Actualizar promedio final del postulante
        $this->actualizarPromedioFinal($postulante);

        return redirect()->route('evaluaciones.index', $postulante)
            ->with('success', "Notas registradas. Promedio: {$promedioMateria} - Estado: " . ($promedioMateria >= 60 ? 'APROBADO' : 'REPROBADO'));
    }

    private function actualizarPromedioFinal(Postulante $postulante)
    {
        $promedioGeneral = $postulante->evaluaciones()
            ->whereNotNull('promedio')
            ->avg('promedio') ?? 0;
        
        $promedioGeneral = round($promedioGeneral, 2);
        
        // CU12: Determinar estado final
        $estadoFinal = $promedioGeneral >= 60 ? 'aprobado' : 'reprobado';
        
        $postulante->update([
            'promedio_final' => $promedioGeneral,
            'estado_academico' => $estadoFinal
        ]);
    }
}