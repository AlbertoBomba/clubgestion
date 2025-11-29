<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $roles = [
            ['name' => 'master', 'guard_name' => 'web'],
            ['name' => 'school_admin', 'guard_name' => 'web'],
            ['name' => 'coach', 'guard_name' => 'web'],
            ['name' => 'student', 'guard_name' => 'web'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']]
            );
        }

        $this->command->info('Roles creados correctamente.');
    }
}
