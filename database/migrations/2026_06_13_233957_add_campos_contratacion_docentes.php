<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('docentes', function (Blueprint $table) {
            // Verificar si no existen para evitar errores
            if (!Schema::hasColumn('docentes', 'titulo_profesional')) {
                $table->boolean('titulo_profesional')->default(true)->after('profesion');
            }
            
            if (!Schema::hasColumn('docentes', 'materias_habilitadas')) {
                $table->json('materias_habilitadas')->nullable()->after('tiene_diplomado_educacion');
            }
            
            if (!Schema::hasColumn('docentes', 'fecha_contratacion')) {
                $table->date('fecha_contratacion')->nullable()->after('materias_habilitadas');
            }
            
            if (!Schema::hasColumn('docentes', 'activo')) {
                $table->boolean('activo')->default(true)->after('fecha_contratacion');
            }
        });
    }

    public function down()
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropColumn([
                'titulo_profesional',
                'materias_habilitadas',
                'fecha_contratacion',
                'activo'
            ]);
        });
    }
};