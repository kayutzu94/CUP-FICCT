<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = ['postulante_id', 'grupo_id', 'fecha', 'presente'];

    protected $casts = [
        'fecha' => 'date',
        'presente' => 'boolean',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}