<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            // IBAN del club para remesas SEPA (pain.008.001.02)
            $table->string('bank_account', 34)->nullable()->after('nif');
        });
    }

    public function down(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->dropColumn('bank_account');
        });
    }
};
