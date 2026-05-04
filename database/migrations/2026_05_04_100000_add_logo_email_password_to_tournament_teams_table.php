<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('external_team');
            $table->string('contact_name')->nullable()->after('logo');
            $table->string('contact_phone')->nullable()->after('contact_name');
            $table->string('email')->nullable()->after('contact_phone');
            $table->string('password')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->dropColumn(['logo', 'contact_name', 'contact_phone', 'email', 'password']);
        });
    }
};
