<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Primero, asegurar que los docentes existen
        $this->call(DocentesSeeder::class);
        
        // Obtener los IDs de los docentes por email
        $docente1 = DB::table('docentes')->where('email', 'ana.gonzales.1@cup.edu.bo')->first();
        $docente2 = DB::table('docentes')->where('email', 'roberto.fernandez.2@cup.edu.bo')->first();
        $docente3 = DB::table('docentes')->where('email', 'fernando.castillo.3@cup.edu.bo')->first();
        $docente4 = DB::table('docentes')->where('email', 'laura.mendez.4@cup.edu.bo')->first();
        
        $usuarios = [
            ['name' => 'Administrador', 'email' => 'admin@cup.edu.bo', 'password' => Hash::make('admin123'), 'role' => 'admin', 'docente_id' => null],
            ['name' => 'Rolando Velasco', 'email' => 'rolando.vsoliz@cup.edu.bo', 'password' => Hash::make('admin123'), 'role' => 'admin', 'docente_id' => null],
            ['name' => 'Nayeli Alvarez', 'email' => 'nayeli@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'coordinador', 'docente_id' => null],
            ['name' => 'Ricardo Antonio', 'email' => 'ricardo@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'coordinador', 'docente_id' => null],
            ['name' => 'Ana Maria Gonzales', 'email' => 'ana.gonzales.1@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente', 'docente_id' => $docente1?->id],
            ['name' => 'Roberto Fernandez', 'email' => 'roberto.fernandez.2@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente', 'docente_id' => $docente2?->id],
            ['name' => 'Fernando Castillo', 'email' => 'fernando.castillo.3@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente', 'docente_id' => $docente3?->id],
            ['name' => 'Laura Mendez', 'email' => 'laura.mendez.4@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente', 'docente_id' => $docente4?->id],
        ];

        foreach ($usuarios as $u) {
            $exists = DB::table('users')->where('email', $u['email'])->exists();
            if (!$exists) {
                DB::table('users')->insert([
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'password' => $u['password'],
                    'role' => $u['role'],
                    'docente_id' => $u['docente_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}