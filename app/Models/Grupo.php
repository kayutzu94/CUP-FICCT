<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = ['codigo', 'nombre', 'capacidad_maxima', 'estudiantes_actuales'];

    public function postulantes()
    {
        return $this->belongsToMany(Postulante::class, 'asignacion_grupos');
    }

    public function tieneCupo()
    {
        return $this->estudiantes_actuales < $this->capacidad_maxima;
    }
}