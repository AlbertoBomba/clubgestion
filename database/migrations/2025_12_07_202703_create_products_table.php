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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // Código del producto
            $table->string('name'); // Nombre del producto
            $table->text('description')->nullable(); // Descripción
            $table->string('category', 100)->nullable(); // Categoría: camiseta, pantalón, etc.
            $table->decimal('price', 10, 2)->default(0); // Precio unitario
            $table->string('image')->nullable(); // Imagen del producto
            $table->boolean('has_sizes')->default(true); // Si tiene tallas o no
            $table->boolean('active')->default(true);
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('products');
    }
};
