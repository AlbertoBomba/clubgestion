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
        Schema::table('players', function (Blueprint $table) {
            $table->decimal('descEnt', 10, 2)->nullable()->after('active')->comment('Descuento en cantidad/entidad');
            $table->decimal('descPerc', 5, 2)->nullable()->after('descEnt')->comment('Descuento en porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['descEnt', 'descPerc']);
        });
    }
};
