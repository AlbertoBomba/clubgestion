<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('phase_id')->constrained('tournament_phases')->onDelete('cascade');
            // Round number (knockout rounds: 1=Final, 2=Semis, etc.)
            $table->unsignedInteger('round')->nullable();
            $table->unsignedInteger('match_number')->nullable();
            // Group label for group-stage matches
            $table->string('group_label')->nullable();
            // Participants (tournament_teams)
            $table->foreignId('home_team_id')->nullable()->constrained('tournament_teams')->onDelete('set null');
            $table->foreignId('away_team_id')->nullable()->constrained('tournament_teams')->onDelete('set null');
            // Regular time score
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();
            // Extra time / penalties score
            $table->unsignedTinyInteger('home_score_extra')->nullable();
            $table->unsignedTinyInteger('away_score_extra')->nullable();
            // Winner on penalties
            $table->enum('penalty_winner', ['home', 'away'])->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('played_at')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'postponed'])->default('scheduled');
            $table->text('notes')->nullable();
            // Flexible settings: leg (1st or 2nd), consolation flag, bracket position, etc.
            $table->json('settings')->nullable();
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_matches');
    }
};
