<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    protected $fillable = ['usuario', 'accion', 'tabla_afectada', 'registro_id', 'detalles', 'ip'];
    
    public static function registrar($accion, $tabla = null, $registroId = null, $detalles = null)
    {
        $user = auth()->user();
        $usuario = $user ? $user->name : 'Sistema';
        
        // Usar DB::table directamente
        return \Illuminate\Support\Facades\DB::table('bitacora')->insert([
            'usuario' => $usuario,
            'accion' => $accion,
            'tabla_afectada' => $tabla,
            'registro_id' => $registroId,
            'detalles' => $detalles,
            'ip' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}