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
        Schema::create('payments_codes_sequentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id');
            $table->integer('sequential')->default(0);
            $table->timestamps();

            // Foreign key
            $table->foreign('sports_school_id')->references('id')->on('sports_schools')->onDelete('cascade');
            
            // Unique constraint to ensure one sequential per sports school
            $table->unique('sports_school_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_codes_sequentials');
    }
};
