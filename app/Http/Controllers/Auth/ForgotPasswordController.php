<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // CU3: Recuperar Contraseña - Mostrar formulario
    public function showLinkRequestForm()
    {
        return view('auth.recover');
    }

    // CU3: Enviar enlace de recuperación
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        Mail::send('auth.reset-password', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Recuperación de Contraseña - CUP FICCT');
        });

        return back()->with('success', 'Te hemos enviado un enlace de recuperación a tu correo.');
    }

    // CU3: Mostrar formulario para nueva contraseña
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // CU3: Actualizar contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Token inválido o expirado.');
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Contraseña actualizada. Ahora puedes iniciar sesión.');
    }
}