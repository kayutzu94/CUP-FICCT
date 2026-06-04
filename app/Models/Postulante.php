<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $fillable = [
        'ci', 'nombres', 'apellidos', 'fecha_nacimiento', 'sexo',
        'direccion', 'telefono', 'email', 'colegio', 'ciudad',
        'titulo_bachiller', 'otros', 'primera_carrera_id', 'segunda_carrera_id',
        'carrera_asignada_id', 'estado_pago', 'estado_academico', 'promedio_final'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function primeraCarrera()
    {
        return $this->belongsTo(Carrera::class, 'primera_carrera_id');
    }

    public function segundaCarrera()
    {
        return $this->belongsTo(Carrera::class, 'segunda_carrera_id');
    }

    public function carreraAsignada()
    {
        return $this->belongsTo(Carrera::class, 'carrera_asignada_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function grupo()
    {
        return $this->belongsToMany(Grupo::class, 'asignacion_grupos');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }
}