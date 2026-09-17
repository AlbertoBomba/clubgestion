<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments_players', function (Blueprint $table) {
            // Justificante de transferencia subido desde el portal público
            $table->string('payment_receipt')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('payments_players', function (Blueprint $table) {
            $table->dropColumn('payment_receipt');
        });
    }
};
