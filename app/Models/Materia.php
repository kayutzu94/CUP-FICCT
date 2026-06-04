<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = ['nombre'];

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }
}