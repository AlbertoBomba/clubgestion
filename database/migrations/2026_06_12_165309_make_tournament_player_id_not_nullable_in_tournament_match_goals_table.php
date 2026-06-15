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
        Schema::table('tournament_match_goals', function (Blueprint $table) {
            $table->foreignId('tournament_player_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournament_match_goals', function (Blueprint $table) {
            $table->foreignId('tournament_player_id')->nullable()->change();
        });
    }
};
