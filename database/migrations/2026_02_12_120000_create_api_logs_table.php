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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sports_school_id')->nullable()->constrained('sports_schools')->onDelete('cascade');
            $table->string('endpoint', 255);
            $table->string('method', 10);
            $table->integer('status_code');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->json('request_params')->nullable();
            $table->integer('response_time')->nullable()->comment('Response time in milliseconds');
            $table->string('error_message', 500)->nullable();
            $table->timestamp('created_at');
            
            // Índices para búsquedas eficientes
            $table->index('sports_school_id');
            $table->index('created_at');
            $table->index('status_code');
            $table->index('endpoint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
