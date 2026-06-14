<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            if (!Schema::hasColumn('carreras', 'cupo')) {
                $table->integer('cupo')->default(0)->after('nombre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropColumn('cupo');
        });
    }
};