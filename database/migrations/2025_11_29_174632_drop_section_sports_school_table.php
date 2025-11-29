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
        Schema::dropIfExists('section_sports_school');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('section_sports_school', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('sports_school_id')->constrained('sports_schools')->onDelete('cascade');
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['section_id', 'sports_school_id']);
        });
    }
};
