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
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->string('api_key', 64)->nullable()->unique()->after('domain');
            $table->timestamp('api_key_generated_at')->nullable();
            $table->integer('api_requests_count')->default(0);
            $table->timestamp('last_api_request_at')->nullable();
            $table->boolean('api_enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->dropColumn([
                'api_key',
                'api_key_generated_at',
                'api_requests_count',
                'last_api_request_at',
                'api_enabled'
            ]);
        });
    }
};
