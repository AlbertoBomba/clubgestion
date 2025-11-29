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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sports_school_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('surname');
            $table->string('dni')->nullable();
            $table->date('dbirth')->nullable();
            $table->integer('dbanio')->nullable();
            $table->string('sizes')->nullable();
            $table->string('dnitutor')->nullable();
            $table->string('nametutor')->nullable();
            $table->string('surnametutor')->nullable();
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(true);
            $table->text('observations')->nullable();
            $table->integer('dorsal')->nullable();
            $table->string('position')->nullable();
            $table->boolean('soccer')->default(false);
            $table->boolean('passport')->default(false);
            $table->boolean('paddle')->default(false);
            $table->boolean('image_right')->default(false);
            $table->string('cod_matricula')->nullable();
            $table->boolean('goalie')->default(false);
            $table->boolean('file')->default(false);
            $table->string('player_photo')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
