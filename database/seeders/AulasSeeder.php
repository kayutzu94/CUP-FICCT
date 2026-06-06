<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulasSeeder extends Seeder
{
    public function run(): void
    {
        $aulas = [
            ['nombre' => 'Aula 101', 'capacidad' => 70],
            ['nombre' => 'Aula 102', 'capacidad' => 70],
            ['nombre' => 'Laboratorio Redes', 'capacidad' => 35],
            ['nombre' => 'Auditorio', 'capacidad' => 150],
        ];

        foreach ($aulas as $a) {
            Aula::updateOrCreate(
                ['nombre' => $a['nombre']],
                ['capacidad' => $a['capacidad']]
            );
        }
    }
}