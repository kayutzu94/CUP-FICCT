<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GruposSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Grupo::updateOrCreate(
                ['codigo' => 'GRP00' . $i],
                [
                    'nombre' => 'Grupo ' . $i,
                    'capacidad_maxima' => 70,
                    'estudiantes_actuales' => 0,
                ]
            );
        }
    }
}