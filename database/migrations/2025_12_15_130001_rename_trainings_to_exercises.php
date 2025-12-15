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
        // Rename trainings table to exercises
        Schema::rename('trainings', 'exercises');
        
        // Rename training_media table to exercise_media
        Schema::rename('training_media', 'exercise_media');
        
        // Update columns in exercise_media
        Schema::table('exercise_media', function (Blueprint $table) {
            $table->renameColumn('training_id', 'exercise_id');
        });
        
        // Add exercise_type_id to exercises table
        Schema::table('exercises', function (Blueprint $table) {
            $table->foreignId('exercise_type_id')->nullable()->after('sports_school_id')->constrained('exercise_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropForeign(['exercise_type_id']);
            $table->dropColumn('exercise_type_id');
        });
        
        Schema::table('exercise_media', function (Blueprint $table) {
            $table->renameColumn('exercise_id', 'training_id');
        });
        
        Schema::rename('exercise_media', 'training_media');
        Schema::rename('exercises', 'trainings');
    }
};
