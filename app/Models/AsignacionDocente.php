<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionDocente extends Model
{
    protected $fillable = ['docente_id', 'grupo_id', 'materia_id', 'fecha_asignacion'];

    protected $casts = [
        'fecha_asignacion' => 'date',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}