<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained('postulantes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias');
            $table->decimal('examen1', 5, 2)->nullable();
            $table->decimal('examen2', 5, 2)->nullable();
            $table->decimal('examen3', 5, 2)->nullable();
            $table->decimal('promedio', 5, 2)->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'reprobado'])->default('pendiente');
            $table->timestamps();
            $table->unique(['postulante_id', 'materia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};