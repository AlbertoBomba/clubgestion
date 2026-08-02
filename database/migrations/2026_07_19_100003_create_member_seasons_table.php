<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_type_id')->constrained()->cascadeOnDelete();
            $table->date('join_date');
            $table->date('leave_date')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('active');
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['member_id', 'season_id']);
            $table->index(['season_id', 'status']);
            $table->index(['member_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_seasons');
    }
};
