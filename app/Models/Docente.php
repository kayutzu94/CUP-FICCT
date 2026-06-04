<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'ci', 'nombres', 'apellidos', 'email', 'telefono',
        'profesion', 'tiene_maestria', 'tiene_diplomado_educacion', 'especialidad', 'activo'
    ];

    // CU19: Validación de requisitos para contratación
    public function cumpleRequisitos()
    {
        return $this->tiene_maestria && $this->tiene_diplomado_educacion;
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