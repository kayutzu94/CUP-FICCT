<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'rol', 'docente_id', // ← Cambiar 'role' a 'rol'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function isAdmin()
    {
        return $this->rol === 'admin'; // ← Cambiar 'role' a 'rol'
    }

    public function isDocente()
    {
        return $this->rol === 'docente'; // ← Cambiar 'role' a 'rol'
    }
    
    public function isCoordinador()
    {
        return $this->rol === 'coordinador'; // ← Cambiar 'role' a 'rol'
    }
}