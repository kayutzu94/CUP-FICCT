<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['codigo', 'nombre', 'capacidad_maxima', 'estudiantes_actuales', 'aula_id', 'activo'];

    public function postulantes()
    {
        return $this->belongsToMany(Postulante::class, 'asignacion_grupos');
    }

    // Relación con Aula (NUEVA)
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    // Relación con Docentes asignados
    public function docentesAsignados()
    {
        return $this->belongsToMany(Docente::class, 'asignacion_docentes')
                    ->withPivot('materia_id');
    }

    public function tieneCupo()
    {
        return $this->estudiantes_actuales < $this->capacidad_maxima;
    }

    public function getPorcentajeOcupacionAttribute()
    {
        return round(($this->estudiantes_actuales / $this->capacidad_maxima) * 100, 2);
    }
}