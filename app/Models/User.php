<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'docente_id',
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
        return $this->role === 'admin';
    }

    public function isDocente()
    {
        return $this->role === 'docente';
    }
    
    public function isCoordinador()
    {
        return $this->role === 'coordinador';
    }

    public function isPostulante()
    {
        return $this->role === 'postulante';
    }
}