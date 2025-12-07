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
        Schema::create('payments_players', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignId('payment_id')->constrained('payments_teams')->onDelete('cascade');
            $table->foreignId('sports_school_id')->constrained('sports_schools')->onDelete('cascade');
            
            // Payment information
            $table->string('code')->nullable();
            $table->tinyInteger('state')->default(0); // 0: pendiente, 1: pagado, 2: cancelado
            $table->string('cuota')->nullable(); // Nombre de la cuota (ej: "1º plazo", "2º plazo")
            $table->decimal('price', 10, 2)->nullable(); // Precio de matrícula del equipo
            $table->decimal('amount', 10, 2)->nullable(); // Importe de esta cuota específica
            
            // Payment details
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_order')->nullable();
            $table->string('payment_auth')->nullable();
            $table->string('payment_type')->nullable(); // efectivo, tarjeta, transferencia, etc.
            
            // Notification
            $table->dateTime('dtnotification')->nullable();
            $table->integer('notification')->default(0);
            
            // Audit fields
            $table->foreignId('created_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_user')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('player_id');
            $table->index('payment_id');
            $table->index('sports_school_id');
            $table->index('state');
            $table->index('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_players');
    }
};
