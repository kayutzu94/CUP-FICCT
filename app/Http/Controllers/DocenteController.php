<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use App\Models\AsignacionDocente;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Docente::query()->with('asignaciones');
        
        // Filtro por cumplimiento de requisitos
        if ($request->has('filter_requisitos')) {
            if ($request->filter_requisitos === 'cumple') {
                // Usar los campos correctos según tu modelo
                $query->where(function($q) {
                    $q->where('titulo_profesional', true)
                    ->where('tiene_maestria', true)
                    ->where('tiene_diplomado_docencia', true)
                    ->where('activo', true);
                });
            } elseif ($request->filter_requisitos === 'no_cumple') {
                $query->where(function($q) {
                    $q->where('titulo_profesional', false)
                    ->orWhere('tiene_maestria', false)
                    ->orWhere('tiene_diplomado_docencia', false)
                    ->orWhere('activo', false);
                });
            }
        }
        
        $docentes = $query->paginate(10);
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    // CU19: Registrar docente con validación de requisitos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ci' => 'required|unique:docentes',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email|unique:docentes',
            'telefono' => 'required',
            'profesion' => 'required',
            'tiene_maestria' => 'boolean',
            'tiene_diplomado_educacion' => 'boolean',
            'especialidad' => 'required',
        ]);

        $docente = Docente::create($validated);
        
        // Validar requisitos para contratación
        if ($docente->cumpleRequisitos()) {
            $mensaje = 'Docente registrado y CONTRATADO (cumple requisitos)';
        } else {
            $mensaje = 'Docente registrado pero NO contratado (no cumple requisitos: necesita Maestría y Diplomado)';
        }
        
        // Crear usuario automáticamente para el docente
        User::create([
            'name' => $docente->nombre_completo,
            'email' => $docente->email,
            'password' => Hash::make($docente->ci),
            'role' => 'docente',
            'docente_id' => $docente->id,
        ]);

        return redirect()->route('docentes.index')->with('success', $mensaje);
    }

    // CU16: Asignar docente a grupos (1-4 grupos) - MODIFICADO CON TRES VALIDACIONES
    public function asignarGrupos(Request $request, Docente $docente)
    {
        // VALIDACIÓN 1: VERIFICAR REQUISITOS DEL DOCENTE
        if (!$docente->cumpleRequisitos()) {
            $pendientes = $docente->getRequisitosPendientes();
            $mensaje = sprintf(
                '❌ No se puede asignar. El docente %s NO cumple con los requisitos necesarios. 📋 Faltan: %s',
                $docente->nombre_completo,
                implode(', ', $pendientes)
            );
            
            return redirect()->route('docentes.index')->with('error', $mensaje);
        }
        
        // VALIDACIÓN 2: VERIFICAR LÍMITE DE GRUPOS Y ESTRUCTURA
        $request->validate([
            'grupos' => 'required|array|min:1',
            'grupos.*' => 'exists:grupos,id',
            'materia_id' => 'required|exists:materias,id',
        ]);

        // VALIDACIÓN 3: VERIFICAR QUE EL DOCENTE PUEDA IMPARTIR LA MATERIA
        $materiaId = $request->materia_id;
        $materia = Materia::find($materiaId);
        
        if (!$docente->puedeImpartirMateria($materiaId)) {
            $materiasHabilitadas = $docente->getMateriasHabilitadasList();
            $nombresMaterias = $materiasHabilitadas->pluck('nombre')->implode(', ');
            
            return redirect()->route('docentes.index')->with('error', 
                "❌ El docente {$docente->nombre_completo} NO está habilitado para impartir la materia '{$materia->nombre}'. " .
                "Materias que puede impartir: " . ($nombresMaterias ?: 'Ninguna según especialidad.')
            );
        }
        
        // VERIFICAR LÍMITE DE ASIGNACIONES (Máximo 4)
        $asignacionesActuales = AsignacionDocente::where('docente_id', $docente->id)->count();
        $nuevasAsignaciones = count($request->grupos);
        $totalAsignaciones = $asignacionesActuales + $nuevasAsignaciones;
        
        if ($totalAsignaciones > 4) {
            $mensaje = sprintf(
                '❌ No se puede asignar. El docente %s ya tiene %d grupo(s) asignado(s). ' .
                'Un docente puede tener máximo 4 grupos. ' .
                'Estás intentando asignar %d grupo(s) más, lo que daría un total de %d grupos.',
                $docente->nombre_completo,
                $asignacionesActuales,
                $nuevasAsignaciones,
                $totalAsignaciones
            );
            
            return redirect()->route('docentes.index')->with('error', $mensaje);
        }
        
        // REALIZAR LAS ASIGNACIONES
        foreach ($request->grupos as $grupoId) {
            AsignacionDocente::updateOrCreate(
                ['docente_id' => $docente->id, 'grupo_id' => $grupoId],
                ['materia_id' => $request->materia_id, 'fecha_asignacion' => now()]
            );
        }
        
        return redirect()->route('docentes.index')
            ->with('success', "✅ Docente asignado a {$nuevasAsignaciones} grupo(s) exitosamente");
    }

    // CU20: Ver carga horaria (acceso exclusivo del docente)
    public function cargaHoraria()
    {
        $user = Auth::user();
        
        if (!$user->isDocente() || !$user->docente_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes perfil de docente');
        }
        
        $docente = Docente::find($user->docente_id);
        $cargaHoraria = Horario::where('docente_id', $docente->id)
            ->with(['grupo', 'materia', 'aula'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();
        
        return view('docentes.carga-horaria', compact('docente', 'cargaHoraria'));
    }

    // Ver detalles de un docente
    public function show(Docente $docente)
    {
        $docente->load(['asignaciones.grupo', 'asignaciones.materia']);
        return view('docentes.show', compact('docente'));
    }

    // Mostrar formulario de edición
    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    // Actualizar docente
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'ci' => 'required|unique:docentes,ci,' . $docente->id,
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $docente->id,
            'telefono' => 'required',
            'profesion' => 'required',
            'especialidad' => 'required',
        ]);
        
        $docente->update($request->all());
        
        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente');
    }

    // Eliminar docente
    public function destroy(Docente $docente)
    {
        // Eliminar usuario asociado
        if ($docente->user) {
            $docente->user->delete();
        }
        
        // Eliminar asignaciones de grupos
        $docente->asignaciones()->delete();
        
        // Eliminar docente
        $docente->delete();
        
        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado exitosamente');
    }
}