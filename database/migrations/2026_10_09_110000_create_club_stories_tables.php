<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sports_school_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 160);
            $table->timestamps();
            $table->unique(['sports_school_id', 'slug']);
        });

        Schema::create('club_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sports_school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('story_category_id')->constrained()->restrictOnDelete();
            $table->string('author_name', 100);
            $table->string('author_email');
            $table->string('title', 150);
            $table->text('body');
            $table->timestamp('consented_at');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('story_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_story_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->unsignedTinyInteger('position');
            $table->timestamps();
        });

        Schema::create('story_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_story_id')->constrained()->cascadeOnDelete();
            $table->string('author_name', 100);
            $table->string('author_email');
            $table->text('body');
            $table->timestamp('consented_at');
            $table->timestamps();
        });

        Schema::create('story_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_story_id')->constrained()->cascadeOnDelete();
            $table->string('visitor_hash', 64);
            $table->timestamps();
            $table->unique(['club_story_id', 'visitor_hash']);
        });

        foreach (['club_stories', 'story_comments', 'story_likes'] as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                $table->string('status', 20)->default('pending');
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('reviewed_at')->nullable();
                $table->string('review_note', 1000)->nullable();
                $table->index([$name === 'club_stories' ? 'sports_school_id' : 'club_story_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('story_likes');
        Schema::dropIfExists('story_comments');
        Schema::dropIfExists('story_media');
        Schema::dropIfExists('club_stories');
        Schema::dropIfExists('story_categories');
    }
};
