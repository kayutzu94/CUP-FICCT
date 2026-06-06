<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarrerasSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            ['nombre' => 'Ingeniería en Sistemas', 'cupo' => 70],
            ['nombre' => 'Ingeniería en Informática', 'cupo' => 65],
            ['nombre' => 'Ingeniería en Redes y Telecomunicaciones', 'cupo' => 60],
            ['nombre' => 'Ingeniería en Robótica', 'cupo' => 55],
        ];

        foreach ($carreras as $c) {
            Carrera::updateOrCreate(
                ['nombre' => $c['nombre']],
                ['cupo' => $c['cupo'], 'inscritos_actuales' => 0]
            );
        }
    }
}