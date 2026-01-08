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
            $table->integer('goals_team')->nullable()->after('observations');
            $table->integer('goals_oponent')->nullable()->after('goals_team');
            $table->string('escudo_team_oponent')->nullable()->after('goals_oponent');
            $table->enum('sites', ['home', 'away'])->nullable()->after('escudo_team_oponent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_matches', function (Blueprint $table) {
            $table->dropColumn(['goals_team', 'goals_oponent', 'escudo_team_oponent', 'sites']);
        });
    }
};
