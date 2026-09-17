<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->string('payment_gateway', 20)
                ->nullable()
                ->default('none')
                ->after('mail_from_name');

            // Encrypted JSON (encrypted:array cast). Text is enough space.
            $table->text('payment_settings')
                ->nullable()
                ->after('payment_gateway');

            $table->boolean('payments_enabled')
                ->default(false)
                ->after('payment_settings');
        });
    }

    public function down(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_settings',
                'payments_enabled',
            ]);
        });
    }
};
