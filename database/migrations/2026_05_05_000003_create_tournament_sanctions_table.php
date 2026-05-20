<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sanciones a jugadores o equipos.
        // La columna tournament_match_id asocia la sanción a la jornada/partido
        // en la que se originó (tarjeta acumulada, expulsión, etc.)
        Schema::create('tournament_sanctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')
                  ->constrained('tournaments')
                  ->onDelete('cascade');
            // Partido/jornada donde se originó la sanción
            $table->foreignId('tournament_match_id')
                  ->nullable()
                  ->constrained('tournament_matches')
                  ->onDelete('set null');
            // La sanción puede ser a un jugador, a un equipo o a ambos
            $table->foreignId('tournament_team_id')
                  ->nullable()
                  ->constrained('tournament_teams')
                  ->onDelete('cascade');
            $table->foreignId('tournament_player_id')
                  ->nullable()
                  ->constrained('tournament_players')
                  ->onDelete('cascade');
            // suspension | warning | fine | disqualification
            $table->string('sanction_type')->default('suspension');
            // Número de partidos de suspensión (0 = sin suspensión / solo aviso)
            $table->unsignedSmallInteger('matches_suspended')->default(0);
            // Partidos ya cumplidos
            $table->unsignedSmallInteger('matches_served')->default(0);
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_sanctions');
    }
};
