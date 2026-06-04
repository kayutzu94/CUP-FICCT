<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionGrupo extends Model
{
    protected $fillable = ['postulante_id', 'grupo_id', 'fecha_asignacion'];

    protected $casts = [
        'fecha_asignacion' => 'date',
    ];
}