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
        // El índice unique_field_schedule ya no es necesario porque 
        // ahora permitimos múltiples equipos en el mismo campo a la misma hora
        // No podemos eliminarlo directamente porque está en conflicto con la FK
        // La solución es recrear la tabla sin ese índice
        
        // Como es una tabla nueva sin datos importantes, podemos recrearla
        Schema::dropIfExists('training_schedules');
        
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_field_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('start_time');
            $table->time('end_time');
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Ya no incluimos el índice único - permitimos múltiples equipos en el mismo horario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_schedules');
        
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('training_field_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->time('start_time');
            $table->time('end_time');
            $table->text('notes')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['training_field_id', 'day_of_week', 'start_time', 'season_id'], 'unique_field_schedule');
        });
    }
};
