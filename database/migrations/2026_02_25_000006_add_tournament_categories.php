<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create tournament_categories table (idempotent)
        if (! Schema::hasTable('tournament_categories')) {
            Schema::create('tournament_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->string('name')->nullable();
                $table->unsignedTinyInteger('order')->default(1);
                $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
                $table->timestamps();
            });
        }

        // 2. Add tournament_category_id to tournament_phases (idempotent)
        if (! Schema::hasColumn('tournament_phases', 'tournament_category_id')) {
            Schema::table('tournament_phases', function (Blueprint $table) {
                $table->foreignId('tournament_category_id')
                    ->nullable()
                    ->after('tournament_id')
                    ->constrained('tournament_categories')
                    ->onDelete('cascade');
            });
        }

        // 3. Add tournament_category_id to tournament_teams + swap unique constraint
        if (! Schema::hasColumn('tournament_teams', 'tournament_category_id')) {
            Schema::table('tournament_teams', function (Blueprint $table) {
                // MySQL needs a standalone index on tournament_id before we can drop the
                // composite unique index that the FK lookup currently uses.
                $table->index('tournament_id', 'tournament_teams_tournament_id_index');
                $table->dropUnique(['tournament_id', 'team_id']);

                $table->foreignId('tournament_category_id')
                    ->nullable()
                    ->after('tournament_id')
                    ->constrained('tournament_categories')
                    ->onDelete('cascade');

                $table->unique(['tournament_category_id', 'team_id'], 'tournament_teams_category_team_unique');
            });
        }

        // 4. Add tournament_category_id to tournament_matches + make phase_id nullable
        if (! Schema::hasColumn('tournament_matches', 'tournament_category_id')) {
            Schema::table('tournament_matches', function (Blueprint $table) {
                $table->foreignId('tournament_category_id')
                    ->nullable()
                    ->after('tournament_id')
                    ->constrained('tournament_categories')
                    ->onDelete('cascade');

                $table->foreignId('phase_id')->nullable()->change();
            });
        }

        // 5. Add tournament_category_id to tournament_standings (idempotent)
        if (! Schema::hasColumn('tournament_standings', 'tournament_category_id')) {
            Schema::table('tournament_standings', function (Blueprint $table) {
                $table->foreignId('tournament_category_id')
                    ->nullable()
                    ->after('tournament_id')
                    ->constrained('tournament_categories')
                    ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('tournament_standings', function (Blueprint $table) {
            $table->dropForeign(['tournament_category_id']);
            $table->dropColumn('tournament_category_id');
        });

        Schema::table('tournament_matches', function (Blueprint $table) {
            $table->dropForeign(['tournament_category_id']);
            $table->dropColumn('tournament_category_id');
            $table->foreignId('phase_id')->nullable(false)->change();
        });

        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->dropUnique('tournament_teams_category_team_unique');
            $table->dropForeign(['tournament_category_id']);
            $table->dropColumn('tournament_category_id');
            $table->unique(['tournament_id', 'team_id']);
            $table->dropIndex('tournament_teams_tournament_id_index');
        });

        Schema::table('tournament_phases', function (Blueprint $table) {
            $table->dropForeign(['tournament_category_id']);
            $table->dropColumn('tournament_category_id');
        });

        Schema::dropIfExists('tournament_categories');
    }
};
