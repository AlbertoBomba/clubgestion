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
        Schema::create('training_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('field_type', ['futbol_11', 'futbol_7', 'futsal', 'polideportivo'])->default('futbol_11');
            $table->enum('surface_type', ['cesped_natural', 'cesped_artificial', 'tierra', 'parquet'])->default('cesped_natural');
            $table->text('description')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('color', 7)->default('#10B981'); // Color hex para visualización
            $table->boolean('active')->default(true);
            $table->foreignId('sports_school_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_fields');
    }
};
