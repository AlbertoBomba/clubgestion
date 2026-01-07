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
            $table->decimal('amount_original', 10, 2)->nullable()->after('amount')->comment('Importe original sin descuento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments_players', function (Blueprint $table) {
            $table->dropColumn('amount_original');
        });
    }
};
