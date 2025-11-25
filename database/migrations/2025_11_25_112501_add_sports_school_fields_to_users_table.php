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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('sports_school_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->enum('role', ['master', 'school_admin', 'coach', 'student'])->default('student')->after('sports_school_id');
            $table->boolean('is_active')->default(true)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sports_school_id']);
            $table->dropColumn(['sports_school_id', 'role', 'is_active']);
        });
    }
};
