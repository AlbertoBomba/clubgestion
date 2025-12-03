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
        Schema::table('sections', function (Blueprint $table) {
            $table->string('color', 7)->default('#8B5CF6')->after('description');
        });

        // Asignar colores predeterminados variados a las secciones existentes
        $colors = ['#8B5CF6', '#EF4444', '#10B981', '#F59E0B', '#3B82F6', '#EC4899', '#14B8A6', '#F97316'];
        $sections = DB::table('sections')->get();
        foreach ($sections as $index => $section) {
            DB::table('sections')
                ->where('id', $section->id)
                ->update(['color' => $colors[$index % count($colors)]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
