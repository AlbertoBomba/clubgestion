<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Dirección postal exigida por la normativa ISO 20022 (SEPA)
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('province')->nullable();

            // Datos bancarios del pagador
            $table->string('bank_account', 34)->nullable();
            $table->string('bank_account_holder')->nullable();

            // Trazabilidad y validez legal del e-Mandato SEPA
            $table->string('sepa_mandate_ref', 35)->nullable();
            $table->dateTime('sepa_mandate_date')->nullable();
            $table->string('sepa_mandate_ip', 45)->nullable();

        });
    }

    public function down(): void
    {
       Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'address', 
                'town', 
                'zip', 
                'province', 
                'bank_account', 
                'bank_account_holder', 
                'sepa_mandate_ref', 
                'sepa_mandate_date'
            ]);
        });
    }
};
