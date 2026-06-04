<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_grupos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained()->onDelete('cascade');
            $table->foreignId('grupo_id')->constrained()->onDelete('cascade');
            $table->date('fecha_asignacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_grupos');
    }
};