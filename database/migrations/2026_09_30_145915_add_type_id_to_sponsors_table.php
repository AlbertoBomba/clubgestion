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
       Schema::table('sponsors', function (Blueprint $table) {
            // Añade el campo como entero numérico positivo sin relación foránea
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('sponsors', function (Blueprint $table) {
            // Elimina la columna si se hace rollback
            $table->dropColumn('type_id');
        });
    }
};
