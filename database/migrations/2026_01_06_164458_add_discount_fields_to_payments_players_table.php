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
        Schema::table('payments_players', function (Blueprint $table) {
            $table->decimal('descEnt', 10, 2)->nullable()->after('amount')->comment('Descuento en euros');
            $table->decimal('descPerc', 5, 2)->nullable()->after('descEnt')->comment('Descuento en porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments_players', function (Blueprint $table) {
            $table->dropColumn(['descEnt', 'descPerc']);
        });
    }
};
