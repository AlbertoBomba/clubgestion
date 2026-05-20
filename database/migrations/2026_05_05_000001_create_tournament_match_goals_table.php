<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_match_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_match_id')
                  ->constrained('tournament_matches')
                  ->onDelete('cascade');
            $table->foreignId('tournament_player_id')
                  ->constrained('tournament_players')
                  ->onDelete('cascade');
            $table->foreignId('tournament_team_id')
                  ->constrained('tournament_teams')
                  ->onDelete('cascade');
            $table->unsignedTinyInteger('minute')->nullable();
            $table->string('goal_type')->default('normal'); // normal | own_goal | penalty
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_match_goals');
    }
};
