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
            $table->boolean('published')->default(false)->after('match_description');
            $table->integer('matchday')->nullable()->after('published');
            $table->text('web_description')->nullable()->after('matchday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_matches', function (Blueprint $table) {
            $table->dropColumn(['published', 'matchday', 'web_description']);
        });
    }
};
