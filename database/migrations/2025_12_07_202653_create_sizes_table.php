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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size', 50); // Talla (XS, S, M, L, XL, XXL, 38, 40, etc.)
            $table->string('description')->nullable(); // Descripción de la talla
            $table->string('category', 50)->default('general'); // Categoría: ropa, calzado, general
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0); // Orden para mostrar
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

            $table->foreign('created_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
