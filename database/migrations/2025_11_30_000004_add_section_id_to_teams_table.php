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
        // Actualizar todos los registros existentes
        $teams = \DB::table('teams')->get();
        
        foreach ($teams as $team) {
            // Buscar una sección de la temporada del equipo
            $section = \DB::table('season_section')
                ->where('season_id', $team->season_id)
                ->first();
            
            if ($section) {
                \DB::table('teams')
                    ->where('id', $team->id)
                    ->update(['section_id' => $section->section_id]);
            } else {
                // Si no hay sección en esa temporada, buscar cualquier sección activa
                $anySection = \DB::table('sections')->where('active', true)->first();
                if ($anySection) {
                    \DB::table('teams')
                        ->where('id', $team->id)
                        ->update(['section_id' => $anySection->id]);
                }
            }
        }
        
        // Agregar foreign key a section_id
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
    }
};
