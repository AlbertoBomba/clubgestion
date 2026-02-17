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
        Schema::create('excel_import_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sports_school_id')->constrained()->onDelete('cascade');
            $table->string('row_hash', 64)->index()->comment('Hash MD5 del contenido de la fila');
            $table->foreignId('payment_id')->nullable()->constrained('payments_players')->onDelete('set null');
            $table->timestamp('imported_at')->useCurrent();
            $table->timestamps();
            
            // Índice compuesto para búsquedas rápidas
            $table->unique(['sports_school_id', 'row_hash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excel_import_rows');
    }
};
