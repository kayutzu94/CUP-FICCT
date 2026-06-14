<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'ci', 'nombres', 'apellidos', 'email', 'telefono', 
        'profesion', 'especialidad', 'tiene_maestria', 
        'tiene_diplomado_educacion', 'titulo_profesional',
        'materias_habilitadas', 'fecha_contratacion', 'activo',
        'observaciones'
    ];

    protected $casts = [
        'tiene_maestria' => 'boolean',
        'tiene_diplomado_educacion' => 'boolean',
        'titulo_profesional' => 'boolean',
        'activo' => 'boolean',
        'materias_habilitadas' => 'array',
        'fecha_contratacion' => 'date',
    ];

    // --- Relaciones ---

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDocente::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'asignacion_docentes')
                    ->withPivot('materia_id', 'fecha_asignacion');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'docente_id');
    }

    // --- Accesorios ---

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    // --- Métodos de Validación y Lógica ---

    /**
     * Verifica si el docente cumple con todos los requisitos para ser contratado
     */
    public function cumpleRequisitos()
    {
        // Asegurar que los campos existen y son true
        return ($this->titulo_profesional ?? false) && 
            ($this->tiene_maestria ?? false) && 
            ($this->tiene_diplomado_docencia ?? false) && 
            ($this->activo ?? true);
    }

    /**
     * Obtiene la lista de requisitos que le faltan al docente
     */
    public function getRequisitosPendientes()
    {
        $pendientes = [];
        
        if (!($this->titulo_profesional ?? false)) {
            $pendientes[] = 'Título profesional';
        }
        if (!($this->tiene_maestria ?? false)) {
            $pendientes[] = 'Maestría';
        }
        if (!($this->tiene_diplomado_docencia ?? false)) {
            $pendientes[] = 'Diplomado en educación superior';
        }
        if (!($this->activo ?? true)) {
            $pendientes[] = 'Estado activo';
        }
        
        return $pendientes;
    }

    /**
     * Verifica si el docente puede impartir una materia específica
     */
    public function puedeImpartirMateria($materiaId)
    {
        $materiasHabilitadas = $this->materias_habilitadas ?? [];
        
        // Si no tiene materias habilitadas configuradas, verificar por especialidad
        if (empty($materiasHabilitadas)) {
            $materias = Materia::where('nombre', 'ILIKE', "%{$this->especialidad}%")->pluck('id')->toArray();
            return in_array($materiaId, $materias);
        }
        
        return in_array($materiaId, $materiasHabilitadas);
    }

    /**
     * Obtiene las materias que el docente puede impartir (para mostrar en formularios)
     */
    public function getMateriasHabilitadasList()
    {
        if (empty($this->materias_habilitadas)) {
            return Materia::where('nombre', 'ILIKE', "%{$this->especialidad}%")->get();
        }
        
        return Materia::whereIn('id', $this->materias_habilitadas)->get();
    }
}