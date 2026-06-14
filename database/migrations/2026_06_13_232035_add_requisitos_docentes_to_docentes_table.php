<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->boolean('titulo_profesional')->default(false);  // Título en el área
            $table->boolean('maestria')->default(false);            // Maestría completada
            $table->boolean('diplomado_docencia')->default(false);  // Diplomado en educación superior
            $table->json('materias_habilitadas')->nullable();       // Materias que puede impartir
            $table->date('fecha_contratacion')->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropColumn([
                'titulo_profesional',
                'maestria',
                'diplomado_docencia',
                'materias_habilitadas',
                'fecha_contratacion',
                'observaciones'
            ]);
        });
    }
};