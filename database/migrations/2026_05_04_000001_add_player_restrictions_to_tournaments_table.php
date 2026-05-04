<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->unsignedInteger('max_players_per_team')->nullable()->after('max_teams');
            $table->date('player_registration_deadline')->nullable()->after('max_players_per_team');
            $table->unsignedInteger('min_age')->nullable()->after('player_registration_deadline');
            $table->enum('team_type', ['school_teams', 'open'])->nullable()->after('min_age');
        });
    }

    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn(['max_players_per_team', 'player_registration_deadline', 'min_age', 'team_type']);
        });
    }
};
