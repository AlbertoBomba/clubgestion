<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('phase_id')->constrained('tournament_phases')->onDelete('cascade');
            $table->foreignId('tournament_team_id')->constrained('tournament_teams')->onDelete('cascade');
            // Group label to support multiple groups per phase
            $table->string('group_label')->nullable();
            $table->unsignedInteger('played')->default(0);
            $table->unsignedInteger('won')->default(0);
            $table->unsignedInteger('drawn')->default(0);
            $table->unsignedInteger('lost')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->integer('points')->default(0);
            $table->unsignedInteger('position')->nullable();
            // Reserved for future: yellow_cards, red_cards, sanctions, etc.
            $table->json('extra')->nullable();
            $table->timestamps();

            $table->unique(['phase_id', 'tournament_team_id'], 'standings_phase_team_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_standings');
    }
};
