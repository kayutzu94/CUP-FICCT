<?php

namespace App\Http\Controllers;

use App\Models\AsignacionDocente;

class AsignacionDocenteController extends Controller
{
    /**
     * Eliminar una asignación docente-grupo
     * Solo administradores pueden realizar esta acción
     */
    public function destroy(AsignacionDocente $asignacion)
    {
        // VERIFICACIÓN MANUAL: Solo administradores pueden desasignar
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }
        
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 
                '❌ Acceso denegado. Solo los administradores pueden desasignar docentes.');
        }
        
        try {
            // Guardar datos para el mensaje de confirmación
            $docenteNombre = $asignacion->docente->nombre_completo ?? 'Docente';
            $grupoNombre = $asignacion->grupo->nombre ?? 'Grupo';
            $materiaNombre = $asignacion->materia->nombre ?? 'materia';
            
            // Eliminar la asignación
            $asignacion->delete();
            
            return redirect()->back()->with('success', 
                "✅ {$docenteNombre} ha sido desasignado del grupo '{$grupoNombre}' ({$materiaNombre})");
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                "❌ Error al desasignar al docente. Por favor, intenta nuevamente.");
        }
    }
}