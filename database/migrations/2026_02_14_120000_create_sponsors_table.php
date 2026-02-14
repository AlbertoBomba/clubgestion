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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->unsignedBigInteger('season_id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('web')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

            $table->foreign('sports_school_id')->references('id')->on('sports_schools')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
