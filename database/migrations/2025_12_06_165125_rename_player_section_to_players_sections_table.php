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
        Schema::rename('player_section', 'players_sections');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('players_sections', 'player_section');
    }
};
