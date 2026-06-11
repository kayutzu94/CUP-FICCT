<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['name' => 'Administrador', 'email' => 'admin@cup.edu.bo', 'password' => Hash::make('admin123'), 'role' => 'admin'],
            ['name' => 'Rolando Velasco', 'email' => 'rolando.vsoliz@cup.edu.bo', 'password' => Hash::make('admin123'), 'role' => 'admin'],
            ['name' => 'Nayeli Alvarez', 'email' => 'nayeli@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'coordinador'],
            ['name' => 'Ricardo Antonio', 'email' => 'ricardo@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'coordinador'],
            ['name' => 'Ana Maria Gonzales', 'email' => 'ana.gonzales.1@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente'],
            ['name' => 'Roberto Fernandez', 'email' => 'roberto.fernandez.2@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente'],
            ['name' => 'Fernando Castillo', 'email' => 'fernando.castillo.3@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente'],
            ['name' => 'Laura Mendez', 'email' => 'laura.mendez.4@cup.edu.bo', 'password' => Hash::make('123456'), 'role' => 'docente'],
        ];

        foreach ($usuarios as $u) {
            $exists = DB::table('users')->where('email', $u['email'])->exists();
            if (!$exists) {
                DB::table('users')->insert([
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'password' => $u['password'],
                    'role' => $u['role'],  // ← Cambiado de 'rol' a 'role'
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}