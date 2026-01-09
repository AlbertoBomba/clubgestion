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
            $table->integer('football_type')->default(11)->after('lineup')->comment('Tipo de fútbol: 7, 8 o 11');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_matches', function (Blueprint $table) {
            $table->dropColumn('football_type');
        });
    }
};
