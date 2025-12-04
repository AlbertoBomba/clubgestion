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
        Schema::rename('teams_users', 'teams_coaches');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('teams_coaches', 'teams_users');
    }
};
