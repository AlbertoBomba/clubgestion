<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_media_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_media_id')->constrained('story_media')->cascadeOnDelete();
            $table->string('visitor_hash', 64);
            $table->date('viewed_on');
            $table->timestamps();
            $table->unique(['story_media_id', 'visitor_hash', 'viewed_on'], 'story_media_views_unique_daily');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_media_views');
    }
};
