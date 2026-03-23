<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            // Null if external team
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            // Name override for external or display purposes
            $table->string('name_override')->nullable();
            $table->boolean('external_team')->default(false);
            $table->enum('status', ['registered', 'confirmed', 'eliminated', 'disqualified'])->default('registered');
            $table->unsignedInteger('seed')->nullable();
            // Group label (A, B, C...) for group-phase assignments
            $table->string('group_label')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tournament_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_teams');
    }
};
