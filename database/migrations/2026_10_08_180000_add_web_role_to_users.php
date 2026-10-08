<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $this->updateRoleEnum(addWeb: true);

        Role::findOrCreate('web', 'web');
    }

    public function down(): void
    {
        $role = Role::findByName('web', 'web');

        if (DB::table('users')->where('role', 'web')->exists() || $role->users()->exists()) {
            throw new RuntimeException('No se puede retirar el rol web mientras tenga usuarios asignados.');
        }

        $this->updateRoleEnum(addWeb: false);

        $role->delete();
    }

    private function updateRoleEnum(bool $addWeb): void
    {
        if (DB::getDriverName() === 'sqlite') {
            $values = ['master', 'school_admin', 'coach', 'student'];
            $values = array_values(array_unique(array_merge(
                $values,
                DB::table('users')->whereNotNull('role')->distinct()->pluck('role')->all(),
                $addWeb ? ['web'] : [],
            )));
            if (! $addWeb) {
                $values = array_values(array_diff($values, ['web']));
            }

            Schema::table('users', function (Blueprint $table) use ($values) {
                $table->enum('role', $values)->default('student')->change();
            });

            return;
        }

        if (! in_array(DB::getDriverName(), ['mysql', 'mariadb'], true)) {
            throw new RuntimeException('La migración del rol web requiere MySQL, MariaDB o SQLite.');
        }

        $table = DB::connection()->getQueryGrammar()->wrapTable('users');
        $column = DB::selectOne("SHOW FULL COLUMNS FROM {$table} WHERE Field = ?", ['role']);

        if (! $column || ! str_starts_with($column->Type, 'enum(') || $column->Extra !== '') {
            throw new RuntimeException('La columna users.role debe ser un enum sin atributos adicionales.');
        }

        $definition = substr($column->Type, 5, -1);
        preg_match_all("/'(?:[^'\\\\]|\\\\.|'')*'/", $definition, $matches);
        $values = $matches[0];

        if (implode(',', $values) !== $definition) {
            throw new RuntimeException('No se ha podido interpretar el enum actual de users.role.');
        }

        if ($addWeb) {
            if (in_array("'web'", $values, true)) {
                return;
            }

            $values[] = "'web'";
        } else {
            if (! in_array("'web'", $values, true)) {
                return;
            }

            if ($column->Default === 'web') {
                throw new RuntimeException('No se puede retirar web mientras sea el rol predeterminado.');
            }

            $values = array_values(array_diff($values, ["'web'"]));
        }

        if ($values === []) {
            throw new RuntimeException('No se puede dejar users.role sin valores permitidos.');
        }

        $type = 'enum('.implode(',', $values).')';
        $collation = str_replace('`', '``', $column->Collation);
        $nullable = $column->Null === 'YES' ? ' NULL' : ' NOT NULL';
        $default = $column->Default !== null
            ? ' DEFAULT '.DB::connection()->getPdo()->quote($column->Default)
            : ($column->Null === 'YES' ? ' DEFAULT NULL' : '');
        $comment = DB::connection()->getPdo()->quote($column->Comment);

        DB::statement("ALTER TABLE {$table} MODIFY `role` {$type} COLLATE `{$collation}`{$nullable}{$default} COMMENT {$comment}");
    }
};
