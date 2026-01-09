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
        Schema::table('match_player', function (Blueprint $table) {
            $table->boolean('card_yellow1')->default(false)->after('confirmed_at');
            $table->boolean('card_yellow2')->default(false)->after('card_yellow1');
            $table->boolean('card_red')->default(false)->after('card_yellow2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('match_player', function (Blueprint $table) {
            $table->dropColumn(['card_yellow1', 'card_yellow2', 'card_red']);
        });
    }
};
