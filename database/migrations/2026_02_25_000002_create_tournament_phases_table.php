<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->string('name');
            // league | group | knockout | swiss | double_elimination
            $table->enum('type', ['league', 'group', 'knockout', 'swiss', 'double_elimination'])->default('league');
            $table->unsignedTinyInteger('order')->default(1);
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            // Settings: points_per_win, points_per_draw, points_per_loss, legs (1 or 2), groups_count, teams_advance, home_away, etc.
            $table->json('settings')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_phases');
    }
};
