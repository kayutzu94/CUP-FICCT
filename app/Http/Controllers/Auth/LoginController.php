<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // CU1: Iniciar Sesión
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Registrar en bitácora el inicio de sesión
            Bitacora::registrar(
                'Inicio de sesión',
                'users',
                $user->id,
                "Usuario {$user->email} inició sesión desde IP: {$request->ip()}"
            );
            
            // Redirigir según el rol
            if ($user->isAdmin()) {
                return redirect()->intended('/dashboard');
            } elseif ($user->isCoordinador()) {
                return redirect()->intended('/dashboard');
            } elseif ($user->isDocente()) {
                // Verificar que el docente tiene perfil completo
                if (!$user->docente_id) {
                    return redirect()->route('dashboard')->with('error', 'Tu perfil de docente no está completo. Contacta al administrador.');
                }
                return redirect()->intended('/docente/carga-horaria');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // CU2: Cerrar Sesión
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Registrar en bitácora el cierre de sesión (si hay usuario logueado)
        if ($user) {
            Bitacora::registrar(
                'Cierre de sesión',
                'users',
                $user->id,
                "Usuario {$user->email} cerró sesión"
            );
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}