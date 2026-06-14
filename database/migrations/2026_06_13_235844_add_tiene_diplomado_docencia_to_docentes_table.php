<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            if (!Schema::hasColumn('docentes', 'tiene_diplomado_docencia')) {
                $table->boolean('tiene_diplomado_docencia')->default(true)->after('tiene_maestria');
            }
        });
    }

    public function down(): void
    {
        Schema::table('docentes', function (Blueprint $table) {
            $table->dropColumn('tiene_diplomado_docencia');
        });
    }
};