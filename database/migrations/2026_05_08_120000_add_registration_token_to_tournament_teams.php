<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->string('registration_token')->nullable()->unique()->after('notes');
        });

        // Generate tokens for existing teams
        \App\Models\TournamentTeam::whereNull('registration_token')->each(function ($team) {
            $team->update(['registration_token' => Str::random(32)]);
        });
    }

    public function down(): void
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->dropColumn('registration_token');
        });
    }
};
