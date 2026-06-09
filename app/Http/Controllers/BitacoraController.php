<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        $registros = Bitacora::orderBy('created_at', 'desc')->paginate(20);
        return view('bitacora.index', compact('registros'));
    }
    
    public function limpiar()
    {
        Bitacora::truncate();
        Bitacora::registrar('Limpieza de bitácora', 'bitacora', null, 'Se limpió todo el historial');
        return redirect()->route('bitacora.index')->with('success', 'Bitácora limpiada exitosamente');
    }
}