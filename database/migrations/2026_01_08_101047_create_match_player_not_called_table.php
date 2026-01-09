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
        Schema::create('match_player_not_called', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('season_matches')->onDelete('cascade');
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->text('reason')->nullable()->comment('Motivo de la baja para ese partido');
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['match_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_player_not_called');
    }
};
