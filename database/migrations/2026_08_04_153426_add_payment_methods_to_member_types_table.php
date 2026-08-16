<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('member_types', function (Blueprint $table) {
            $table->boolean('bank_account')->default(false);
            $table->boolean('credit_card')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('member_types', function (Blueprint $table) {
            $table->dropColumn(['bank_account', 'credit_card']);
        });
    }
};
