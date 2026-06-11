<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Orden correcto: Primero las tablas independientes
        $this->call(CarrerasSeeder::class);
        $this->call(MateriasSeeder::class);
        $this->call(AulasSeeder::class);
        $this->call(DocentesSeeder::class); // ← MUY IMPORTANTE: Antes de Usuarios
        $this->call(GruposSeeder::class);
        $this->call(UsuariosSeeder::class); // ← Después de Docentes
    }
}