<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_team_id')->constrained('tournament_teams')->onDelete('cascade');

            // Datos personales
            $table->string('name');
            $table->string('surname')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('dni')->nullable();        // Número de documento
            $table->enum('doc_type', ['dni', 'nie', 'passport'])->nullable();

            // Datos deportivos
            $table->string('position')->nullable();   // Posición en el campo
            $table->unsignedSmallInteger('dorsal')->nullable();

            // Datos de contacto
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Archivos
            $table->string('photo')->nullable();      // Foto carnet
            $table->string('doc_front')->nullable();  // Cara A del DNI/pasaporte
            $table->string('doc_back')->nullable();   // Cara B del DNI (null para pasaporte)

            // Estado y notas
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_players');
    }
};
