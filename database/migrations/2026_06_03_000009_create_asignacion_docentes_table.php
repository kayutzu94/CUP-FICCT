<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained();
            $table->foreignId('grupo_id')->constrained();
            $table->foreignId('materia_id')->constrained();
            $table->date('fecha_asignacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_docentes');
    }
};