<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('web_home_slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            // 'image' o 'video'
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('media_path')->nullable();
            // Color de fondo cuando no hay imagen/video
            $table->string('background_color')->nullable()->default('#1E40AF');
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sports_school_id')->references('id')->on('sports_schools')->onDelete('cascade');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_home_slides');
    }
};
