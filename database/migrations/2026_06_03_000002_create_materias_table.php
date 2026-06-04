<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->timestamps();
        });

        DB::table('materias')->insert([
            ['nombre' => 'Computación'],
            ['nombre' => 'Matemáticas'],
            ['nombre' => 'Inglés'],
            ['nombre' => 'Física'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};