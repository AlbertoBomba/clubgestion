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
        Schema::table('sizes', function (Blueprint $table) {
            if (!Schema::hasColumn('sizes', 'edad')) {
                $table->integer('edad')->nullable()->after('id');
            }
            if (!Schema::hasColumn('sizes', 'pecho')) {
                $table->string('pecho')->nullable()->after('edad');
            }
            if (!Schema::hasColumn('sizes', 'cintura')) {
                $table->string('cintura')->nullable()->after('pecho');
            }
            if (!Schema::hasColumn('sizes', 'cadera')) {
                $table->string('cadera')->nullable()->after('cintura');
            }
            if (!Schema::hasColumn('sizes', 'brand_id')) {
                $table->foreignId('brand_id')->nullable()->after('cadera')->constrained('brands')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['edad', 'pecho', 'cintura', 'cadera', 'brand_id']);
        });
    }
};
