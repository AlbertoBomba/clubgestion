<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['club_stories', 'story_comments'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->string('author_email')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        foreach (['club_stories', 'story_comments'] as $name) {
            if (DB::table($name)->whereNull('author_email')->exists()) {
                throw new RuntimeException('No se puede hacer obligatorio el correo mientras existan historias o comentarios sin correo.');
            }
        }

        foreach (['club_stories', 'story_comments'] as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->string('author_email')->nullable(false)->change();
            });
        }
    }
};
