<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_season_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 8, 2);
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->string('status')->default('pending');
            $table->string('concept');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['member_season_id', 'status']);
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_payments');
    }
};
