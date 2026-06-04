<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulantes', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 20)->unique();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('direccion');
            $table->string('telefono', 20);
            $table->string('email')->unique();
            $table->string('colegio');
            $table->string('ciudad');
            $table->string('titulo_bachiller');
            $table->text('otros')->nullable();
            $table->foreignId('primera_carrera_id')->constrained('carreras');
            $table->foreignId('segunda_carrera_id')->constrained('carreras');
            $table->foreignId('carrera_asignada_id')->nullable()->constrained('carreras');
            $table->enum('estado_pago', ['pendiente', 'pagado'])->default('pendiente');
            $table->enum('estado_academico', ['inscrito', 'aprobado', 'reprobado'])->default('inscrito');
            $table->decimal('promedio_final', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulantes');
    }
};