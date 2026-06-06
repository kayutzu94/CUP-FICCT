<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'coordinador', 'docente'];
        echo "Roles disponibles: " . implode(', ', $roles) . "\n";
    }
}