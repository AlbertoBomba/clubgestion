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
        Schema::create('product_stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id')->nullable(); // Nullable para productos sin tallas
            $table->integer('quantity')->default(0); // Cantidad en stock
            $table->integer('min_stock')->default(0); // Stock mínimo para alertas
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('set null');

            // Un producto solo puede tener un stock por talla
            $table->unique(['product_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stock');
    }
};
