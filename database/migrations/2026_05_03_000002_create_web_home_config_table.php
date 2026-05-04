<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('web_home_config', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sports_school_id')->unique();

            // Stats section
            $table->integer('stats_years')->default(80);

            // Membership / Socios section
            $table->boolean('membership_show')->default(true);
            $table->string('membership_title')->default('Hazte Socio');
            $table->text('membership_subtitle')->nullable();
            $table->string('benefit_1_title')->default('Descuentos');
            $table->text('benefit_1_description')->nullable();
            $table->string('benefit_2_title')->default('Eventos');
            $table->text('benefit_2_description')->nullable();
            $table->string('benefit_3_title')->default('Prioridad');
            $table->text('benefit_3_description')->nullable();
            $table->string('membership_button_text')->default('Únete Ahora');
            $table->string('membership_button_url')->nullable();

            // Contact section
            $table->boolean('contact_show')->default(true);
            $table->string('contact_title')->default('¿Tienes Preguntas?');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sports_school_id')->references('id')->on('sports_schools')->onDelete('cascade');
            $table->foreign('created_user')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_user')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_home_config');
    }
};
