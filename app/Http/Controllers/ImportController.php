<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Carrera;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    // CU26: Importación masiva CSV y Excel
    public function index()
    {
        return view('importacion.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:csv,xlsx,xls',
        ]);

        $archivo = $request->file('archivo');
        $handle = fopen($archivo->getPathname(), 'r');
        
        $headers = fgetcsv($handle, 1000, ',');
        $importados = 0;
        $errores = [];
        
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $row = array_combine($headers, $data);
            
            $validator = \Validator::make($row, [
                'ci' => 'required|unique:postulantes',
                'nombres' => 'required',
                'apellidos' => 'required',
                'email' => 'required|email|unique:postulantes',
                'primera_carrera' => 'required',
                'segunda_carrera' => 'required',
            ]);
            
            if ($validator->fails()) {
                $errores[] = "Error en fila: " . implode(', ', $validator->errors()->all());
                continue;
            }
            
            $primera = Carrera::where('nombre', 'like', '%' . $row['primera_carrera'] . '%')->first();
            $segunda = Carrera::where('nombre', 'like', '%' . $row['segunda_carrera'] . '%')->first();
            
            if (!$primera || !$segunda) {
                $errores[] = "Carrera no encontrada para CI: " . $row['ci'];
                continue;
            }
            
            $postulante = Postulante::create([
                'ci' => $row['ci'],
                'nombres' => $row['nombres'],
                'apellidos' => $row['apellidos'],
                'email' => $row['email'],
                'fecha_nacimiento' => $row['fecha_nacimiento'] ?? '2000-01-01',
                'sexo' => $row['sexo'] ?? 'M',
                'direccion' => $row['direccion'] ?? '',
                'telefono' => $row['telefono'] ?? '',
                'colegio' => $row['colegio'] ?? '',
                'ciudad' => $row['ciudad'] ?? '',
                'titulo_bachiller' => $row['titulo_bachiller'] ?? 'Bachiller',
                'primera_carrera_id' => $primera->id,
                'segunda_carrera_id' => $segunda->id,
            ]);
            
            // Asignar carrera por cupo
            if ($primera->tieneCupoDisponible()) {
                $primera->increment('inscritos_actuales');
                $postulante->update(['carrera_asignada_id' => $primera->id]);
            } elseif ($segunda->tieneCupoDisponible()) {
                $segunda->increment('inscritos_actuales');
                $postulante->update(['carrera_asignada_id' => $segunda->id]);
            }
            
            $importados++;
        }
        
        fclose($handle);
        
        return redirect()->route('importacion.index')
            ->with('success', "Importados: $importados postulantes. Errores: " . count($errores));
    }
}