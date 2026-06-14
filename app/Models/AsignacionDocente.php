<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionDocente extends Model
{
    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'asignacion_docentes';
    
    /**
     * Los atributos que son asignables en masa.
     */
    protected $fillable = [
        'docente_id', 
        'grupo_id', 
        'materia_id', 
        'fecha_asignacion'
    ];
    
    /**
     * Conversión de tipos para los atributos.
     */
    protected $casts = [
        'fecha_asignacion' => 'date'
    ];
    
    /**
     * Relación: Una asignación pertenece a un docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }
    
    /**
     * Relación: Una asignación pertenece a un grupo.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
    
    /**
     * Relación: Una asignación pertenece a una materia.
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}