<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = ['nombre', 'cupo', 'inscritos_actuales'];

    public function tieneCupoDisponible()
    {
        return $this->inscritos_actuales < $this->cupo;
    }

    public function incrementarInscritos()
    {
        $this->increment('inscritos_actuales');
    }

    public function postulantesAsignados()
    {
        return $this->hasMany(Postulante::class, 'carrera_asignada_id')
                    ->where('estado_academico', 'aprobado');
    }
}