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
        Schema::table('season_matches', function (Blueprint $table) {
            $table->string('formation')->nullable()->after('sites')->comment('Formación táctica (ej: 1-4-3-3)');
            $table->json('lineup')->nullable()->after('formation')->comment('Alineación titular con posiciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_matches', function (Blueprint $table) {
            $table->dropColumn(['formation', 'lineup']);
        });
    }
};
