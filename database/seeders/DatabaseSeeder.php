<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CarrerasSeeder::class,
            MateriasSeeder::class,
            AulasSeeder::class,
            GruposSeeder::class,
            UsuariosSeeder::class,
            PostulantesSeeder::class,
        ]);
    }
}