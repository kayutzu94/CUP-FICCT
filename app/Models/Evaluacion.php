<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    
    protected $fillable = [
        'postulante_id', 'materia_id', 'examen1', 'examen2', 'examen3', 'promedio', 'estado'
    ];

    protected $casts = [
        'examen1' => 'decimal:2',
        'examen2' => 'decimal:2',
        'examen3' => 'decimal:2',
        'promedio' => 'decimal:2',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    // CU11: Calcular promedio = (N1+N2+N3)/3
    public function calcularPromedio()
    {
        $n1 = $this->examen1 ?? 0;
        $n2 = $this->examen2 ?? 0;
        $n3 = $this->examen3 ?? 0;
        
        $this->promedio = round(($n1 + $n2 + $n3) / 3, 2);
        
        // CU12: Determinar estado
        $this->estado = $this->promedio >= 60 ? 'aprobado' : 'reprobado';
        $this->save();
        
        return $this->promedio;
    }
}