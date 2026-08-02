<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            // Se crea como booleano con valor por defecto false
            $table->boolean('live')->default(false)->after('status'); // Puedes cambiar 'status' por la columna donde quieras ubicarlo
        });
    }

    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('live');
        });
    }
};
