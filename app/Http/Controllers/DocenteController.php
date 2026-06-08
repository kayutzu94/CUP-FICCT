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
    public function index()
    {
        $docentes = Docente::paginate(10);
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

    // CU16: Asignar docente a grupos (1-4 grupos)
    public function asignarGrupos(Request $request, Docente $docente)
    {
        $request->validate([
            'grupos' => 'required|array|min:1|max:4',
            'grupos.*' => 'exists:grupos,id',
            'materia_id' => 'required|exists:materias,id',
        ]);
        
        $asignacionesActuales = AsignacionDocente::where('docente_id', $docente->id)->count();
        $nuevasAsignaciones = count($request->grupos);
        
        if ($asignacionesActuales + $nuevasAsignaciones > 4) {
            return back()->with('error', 'Un docente no puede ser asignado a más de 4 grupos. Actualmente tiene ' . $asignacionesActuales . ' grupos.');
        }
        
        foreach ($request->grupos as $grupoId) {
            // Verificar si ya está asignado a este grupo con esta materia
            $existe = AsignacionDocente::where('docente_id', $docente->id)
                ->where('grupo_id', $grupoId)
                ->where('materia_id', $request->materia_id)
                ->exists();
                
            if (!$existe) {
                AsignacionDocente::create([
                    'docente_id' => $docente->id,
                    'grupo_id' => $grupoId,
                    'materia_id' => $request->materia_id,
                    'fecha_asignacion' => now(),
                ]);
            }
        }
        
        return redirect()->route('docentes.index')
            ->with('success', 'Docente asignado a ' . $nuevasAsignaciones . ' grupo(s)');
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