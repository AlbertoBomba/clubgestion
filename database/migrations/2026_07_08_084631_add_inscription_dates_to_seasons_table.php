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
        Schema::table('seasons', function (Blueprint $table) {
            // Añadimos los campos de fecha para las inscripciones
            $table->date('inscription_start_at')->nullable()->comment('Inicio del periodo de inscripciones');
            $table->date('inscription_end_at')->nullable()->comment('Fin del periodo de inscripciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seasons', function (Blueprint $table) {
            // Si hacemos rollback, eliminamos los campos para no dejar rastro
            $table->dropColumn(['inscription_start_at', 'inscription_end_at']);
        });
    }
};