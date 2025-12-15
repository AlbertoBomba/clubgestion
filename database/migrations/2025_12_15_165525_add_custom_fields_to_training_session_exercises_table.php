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
        Schema::table('training_session_exercises', function (Blueprint $table) {
            $table->string('custom_image')->nullable()->after('custom_description');
            $table->string('custom_intensity')->nullable()->after('custom_image');
            $table->string('custom_difficulty')->nullable()->after('custom_intensity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_session_exercises', function (Blueprint $table) {
            $table->dropColumn(['custom_image', 'custom_intensity', 'custom_difficulty']);
        });
    }
};
