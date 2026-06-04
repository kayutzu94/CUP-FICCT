<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        if ($user->role !== $role && $user->role !== 'admin') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}