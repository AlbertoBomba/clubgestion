<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tournament_players', function (Blueprint $table) {
            $table->boolean('federado')->default(false)->after('status');
            $table->string('categoria')->nullable()->after('federado');
            $table->json('extra_documents')->nullable()->after('categoria');
        });
    }

    public function down(): void
    {
        Schema::table('tournament_players', function (Blueprint $table) {
            $table->dropColumn(['federado', 'categoria', 'extra_documents']);
        });
    }
};
