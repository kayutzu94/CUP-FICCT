<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        $materias = ['Computación', 'Matemáticas', 'Inglés', 'Física'];

        foreach ($materias as $materia) {
            // Verificar si ya existe
            $existe = Materia::where('nombre', $materia)->first();
            
            if (!$existe) {
                Materia::create([
                    'nombre' => $materia,
                ]);
            }
        }
    }
}