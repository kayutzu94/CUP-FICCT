<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 20)->unique();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('email')->unique();
            $table->string('telefono', 20);
            $table->string('profesion', 100);
            $table->boolean('tiene_maestria')->default(false);
            $table->boolean('tiene_diplomado_educacion')->default(false);
            $table->string('especialidad', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};