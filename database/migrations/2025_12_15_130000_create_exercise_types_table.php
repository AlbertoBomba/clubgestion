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
        Schema::create('exercise_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default types
        DB::table('exercise_types')->insert([
            ['name' => 'Táctico', 'description' => 'Ejercicios de táctica y estrategia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Físico', 'description' => 'Ejercicios de preparación física', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lúdico', 'description' => 'Ejercicios lúdicos y recreativos', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_types');
    }
};
