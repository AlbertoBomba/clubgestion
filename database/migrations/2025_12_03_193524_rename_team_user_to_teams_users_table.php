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
        Schema::rename('team_user', 'teams_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('teams_users', 'team_user');
    }
};
