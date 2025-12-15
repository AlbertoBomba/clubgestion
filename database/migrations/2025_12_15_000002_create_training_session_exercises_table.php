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
        Schema::create('training_session_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->nullable()->constrained()->onDelete('cascade'); // Null for custom exercises
            $table->integer('order')->default(0); // Order of exercises in session
            $table->string('custom_title')->nullable(); // For free/custom exercises
            $table->text('custom_description')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('recommended_players')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_session_exercises');
    }
};
