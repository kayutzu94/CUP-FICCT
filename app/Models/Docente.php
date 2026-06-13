<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'ci', 'nombres', 'apellidos', 'email', 'telefono',
        'profesion', 'tiene_maestria', 'tiene_diplomado_educacion', 'especialidad', 'activo'
    ];

    // CU19: Validación de requisitos para contratación (Unificado)
    public function cumpleRequisitos()
    {
        // Define aquí los criterios académicos y de estado que debe cumplir el docente
        $requisitos = [
            'tiene_maestria' => $this->tiene_maestria ?? false,
            'tiene_diplomado' => $this->tiene_diplomado_educacion ?? false,
            'estado_activo' => (bool)($this->activo ?? true),
        ];
        
        // Verificar que todos los requisitos se cumplan (que no haya ningún false)
        return !in_array(false, $requisitos);
    }

    // Obtener la lista de requisitos que aún no cumple el docente
    public function getRequisitosPendientes()
    {
        $pendientes = [];
        
        if (!($this->tiene_maestria ?? false)) {
            $pendientes[] = 'Título de Maestría';
        }
        if (!($this->tiene_diplomado_educacion ?? false)) {
            $pendientes[] = 'Diplomado en Educación Superior';
        }
        if (!($this->activo ?? true)) {
            $pendientes[] = 'Estado activo en el sistema';
        }
        
        return $pendientes;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDocente::class);
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }
}