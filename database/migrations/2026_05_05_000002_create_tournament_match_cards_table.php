<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_match_cards', function (Blueprint $table) {
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
            // yellow | red | double_yellow (2ª amarilla = roja)
            $table->string('card_type');
            $table->unsignedTinyInteger('minute')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_match_cards');
    }
};
