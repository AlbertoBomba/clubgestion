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
            $table->boolean('email_notification')->default(false);
            $table->boolean('whatsapp_notification')->default(false);
            $table->boolean('sms_notification')->default(false);
            $table->boolean('push_notification')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments_players', function (Blueprint $table) {
            $table->dropColumn([
                'email_notification',
                'whatsapp_notification',
                'sms_notification',
                'push_notification',
            ]);
        });
    }
};
