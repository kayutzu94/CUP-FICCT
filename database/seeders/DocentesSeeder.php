<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocentesSeeder extends Seeder
{
    public function run(): void
    {
        $docentes = [
            [
                'ci' => '12345601',
                'nombres' => 'Ana Maria',
                'apellidos' => 'Gonzales',
                'email' => 'ana.gonzales.1@cup.edu.bo',
                'telefono' => '71234561',
                'profesion' => 'Ingeniera de Sistemas',
                'tiene_maestria' => true,
                'tiene_diplomado_educacion' => true,
                'especialidad' => 'Bases de Datos',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ci' => '12345602',
                'nombres' => 'Roberto',
                'apellidos' => 'Fernandez',
                'email' => 'roberto.fernandez.2@cup.edu.bo',
                'telefono' => '71234562',
                'profesion' => 'Ingeniero en Informática',
                'tiene_maestria' => true,
                'tiene_diplomado_educacion' => false,
                'especialidad' => 'Redes',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ci' => '12345603',
                'nombres' => 'Fernando',
                'apellidos' => 'Castillo',
                'email' => 'fernando.castillo.3@cup.edu.bo',
                'telefono' => '71234563',
                'profesion' => 'Licenciado en Matemáticas',
                'tiene_maestria' => true,
                'tiene_diplomado_educacion' => true,
                'especialidad' => 'Matemática Aplicada',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'ci' => '12345604',
                'nombres' => 'Laura',
                'apellidos' => 'Mendez',
                'email' => 'laura.mendez.4@cup.edu.bo',
                'telefono' => '71234564',
                'profesion' => 'Ingeniera de Sistemas',
                'tiene_maestria' => false,
                'tiene_diplomado_educacion' => true,
                'especialidad' => 'Desarrollo Web',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        foreach ($docentes as $docente) {
            $exists = DB::table('docentes')->where('email', $docente['email'])->exists();
            if (!$exists) {
                DB::table('docentes')->insert($docente);
            }
        }
    }
}