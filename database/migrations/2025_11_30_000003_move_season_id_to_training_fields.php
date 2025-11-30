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
        // Eliminar la tabla pivote con season_id
        Schema::dropIfExists('section_training_field');
        
        // Recrear la tabla pivote sin season_id
        Schema::create('section_training_field', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('training_field_id')->constrained('training_fields')->onDelete('cascade');
            $table->timestamps();

            // Evitar duplicados
            $table->unique(['section_id', 'training_field_id']);
        });
        
        // Actualizar registros existentes de training_fields con la temporada activa
        $activeSeason = \App\Models\Season::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
            
        if ($activeSeason) {
            // Actualizar todos los registros para asegurar que tengan un season_id válido
            \DB::table('training_fields')->update(['season_id' => $activeSeason->id]);
        } else {
            // Si no hay temporada activa, usar la primera temporada disponible
            $firstSeason = \DB::table('seasons')->orderBy('id')->first();
            if ($firstSeason) {
                \DB::table('training_fields')->update(['season_id' => $firstSeason->id]);
            }
        }
        
        // Agregar foreign key a season_id en training_fields
        Schema::table('training_fields', function (Blueprint $table) {
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar season_id de training_fields
        Schema::table('training_fields', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
        
        // Eliminar la tabla pivote
        Schema::dropIfExists('section_training_field');
        
        // Recrear la tabla pivote con season_id (estado anterior)
        Schema::create('section_training_field', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->foreignId('training_field_id')->constrained('training_fields')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['section_id', 'training_field_id', 'season_id'], 'section_field_season_unique');
        });
    }
};
