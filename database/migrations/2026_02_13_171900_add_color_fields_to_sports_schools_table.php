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
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->string('primary_color', 7)->nullable()->after('logo')->comment('Color principal en formato hexadecimal (#RRGGBB)');
            $table->string('secondary_color', 7)->nullable()->after('primary_color')->comment('Color secundario en formato hexadecimal (#RRGGBB)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sports_schools', function (Blueprint $table) {
            $table->dropColumn(['primary_color', 'secondary_color']);
        });
    }
};
