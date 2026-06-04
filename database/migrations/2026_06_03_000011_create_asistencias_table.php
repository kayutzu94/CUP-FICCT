<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained()->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained();
            $table->date('fecha');
            $table->boolean('presente')->default(false);
            $table->timestamps();
            $table->unique(['postulante_id', 'grupo_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};