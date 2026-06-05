<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Carrera;
use App\Models\Evaluacion;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostulanteController extends Controller
{
    // CU8: Listar Postulantes
    public function index()
    {
        $postulantes = Postulante::with(['primeraCarrera', 'segundaCarrera', 'carreraAsignada'])
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('postulantes.index', compact('postulantes'));
    }

    // CU4: Mostrar formulario de registro
    public function create()
    {
        // Verificar rol
        if (!in_array(auth()->user()->role, ['admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para registrar postulantes.');
        }
        
        $carreras = Carrera::all();
        return view('postulantes.create', compact('carreras'));
    }

    // CU4: Registrar Postulante + CU13: Asignar segunda opción
    public function store(Request $request)
    {
        // Verificar rol
        if (!in_array(auth()->user()->role, ['admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para registrar postulantes.');
        }
        
        $validated = $request->validate([
            'ci' => 'required|unique:postulantes|max:20',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'direccion' => 'required',
            'telefono' => 'required|max:20',
            'email' => 'required|email|unique:postulantes',
            'colegio' => 'required',
            'ciudad' => 'required',
            'titulo_bachiller' => 'required|string|min:5',
            'primera_carrera_id' => 'required|exists:carreras,id',
            'segunda_carrera_id' => 'required|exists:carreras,id|different:primera_carrera_id',
            'otros' => 'nullable',
        ]);

        // Validación adicional para el título de bachiller
        $tituloBachiller = strtolower(trim($request->titulo_bachiller));
        $palabrasInvalidas = ['ninguno', 'ningun', 'no', 'n/a', 'na', 'sin', 'ninguna'];
        
        if (in_array($tituloBachiller, $palabrasInvalidas) || strlen($tituloBachiller) < 5) {
            return back()->withErrors(['titulo_bachiller' => 'Debe ingresar un título de bachiller válido (ej: Bachiller en Humanidades, Técnico, etc.).'])
                        ->withInput();
        }

        $postulante = Postulante::create($validated);
        
        // CU13: Asignar carrera por cupo (primera o segunda opción)
        $this->asignarCarreraPorCupo($postulante);
        
        // Crear evaluaciones para las 4 materias
        $this->crearEvaluacionesIniciales($postulante);

        return redirect()->route('postulantes.index')
            ->with('success', 'Postulante registrado exitosamente. Carrera asignada: ' . ($postulante->carreraAsignada->nombre ?? 'Pendiente'));
    }

    // CU13: Lógica de asignación por cupos
    private function asignarCarreraPorCupo(Postulante $postulante)
    {
        $primera = Carrera::find($postulante->primera_carrera_id);
        
        if ($primera && $primera->tieneCupoDisponible()) {
            $primera->increment('inscritos_actuales');
            $postulante->update(['carrera_asignada_id' => $primera->id]);
            return;
        }
        
        $segunda = Carrera::find($postulante->segunda_carrera_id);
        if ($segunda && $segunda->tieneCupoDisponible()) {
            $segunda->increment('inscritos_actuales');
            $postulante->update(['carrera_asignada_id' => $segunda->id]);
        }
    }

    private function crearEvaluacionesIniciales(Postulante $postulante)
    {
        $materias = Materia::all();
        
        foreach ($materias as $materia) {
            Evaluacion::create([
                'postulante_id' => $postulante->id,
                'materia_id' => $materia->id,
                'estado' => 'pendiente'
            ]);
        }
    }

    // CU5: Mostrar formulario de edición
    public function edit(Postulante $postulante)
    {
        // Verificar rol
        if (!in_array(auth()->user()->role, ['admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para editar postulantes.');
        }
        
        $carreras = Carrera::all();
        return view('postulantes.edit', compact('postulante', 'carreras'));
    }

    // CU5: Modificar Datos del Postulante
    public function update(Request $request, Postulante $postulante)
    {
        // Verificar rol
        if (!in_array(auth()->user()->role, ['admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para editar postulantes.');
        }
        
        $validated = $request->validate([
            'ci' => ['required', 'max:20', Rule::unique('postulantes')->ignore($postulante->id)],
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'direccion' => 'required',
            'telefono' => 'required|max:20',
            'email' => ['required', 'email', Rule::unique('postulantes')->ignore($postulante->id)],
            'colegio' => 'required',
            'ciudad' => 'required',
            'titulo_bachiller' => 'required',
            'primera_carrera_id' => 'required|exists:carreras,id',
            'segunda_carrera_id' => 'required|exists:carreras,id|different:primera_carrera_id',
            'otros' => 'nullable',
        ]);

        $postulante->update($validated);
        
        // Reasignar carrera si cambió
        $this->asignarCarreraPorCupo($postulante);

        return redirect()->route('postulantes.index')
            ->with('success', 'Postulante actualizado exitosamente');
    }

    // CU6: Eliminar Postulante (Solo Admin puede eliminar)
    public function destroy(Postulante $postulante)
    {
        // Solo Admin puede eliminar
        if (auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para eliminar postulantes. Solo el administrador puede hacer esto.');
        }
        
        // Liberar cupo de carrera
        if ($postulante->carrera_asignada_id) {
            $carrera = Carrera::find($postulante->carrera_asignada_id);
            if ($carrera && $carrera->inscritos_actuales > 0) {
                $carrera->decrement('inscritos_actuales');
            }
        }
        
        $postulante->delete();
        return redirect()->route('postulantes.index')
            ->with('success', 'Postulante eliminado exitosamente');
    }

    // CU7: Buscar Postulante (Todos pueden ver)
    public function search(Request $request)
    {
        $search = $request->get('search');
        $postulantes = Postulante::where('ci', 'LIKE', "%{$search}%")
            ->orWhere('nombres', 'LIKE', "%{$search}%")
            ->orWhere('apellidos', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('ci', 'LIKE', "%{$search}%")
            ->paginate(15);
        
        return view('postulantes.index', compact('postulantes'));
    }

    // Ver detalles (Todos pueden ver)
    public function show(Postulante $postulante)
    {
        $postulante->load(['primeraCarrera', 'segundaCarrera', 'carreraAsignada', 'evaluaciones.materia']);
        return view('postulantes.show', compact('postulante'));
    }
}