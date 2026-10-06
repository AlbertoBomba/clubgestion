<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member_seasons', function (Blueprint $table) {
            // Fecha en la que se avisó al socio del cargo bancario (evita notificar dos veces)
            $table->dateTime('charge_notified_at')->nullable()->after('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('member_seasons', function (Blueprint $table) {
            $table->dropColumn('charge_notified_at');
        });
    }
};
