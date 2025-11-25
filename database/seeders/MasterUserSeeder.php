<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario Master
        $master = User::create([
            'name' => 'Administrador Master',
            'email' => 'master@clubsportal.com',
            'password' => Hash::make('password'),
            'role' => 'master',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✓ Usuario Master creado: master@clubsportal.com / password');

        // Crear escuelas deportivas de ejemplo
        $school1 = SportsSchool::create([
            'name' => 'Club Deportivo Madrid',
            'slug' => 'club-deportivo-madrid',
            'description' => 'Escuela deportiva de fútbol y baloncesto en Madrid',
            'address' => 'Calle Mayor 123',
            'city' => 'Madrid',
            'postal_code' => '28013',
            'phone' => '912345678',
            'email' => 'info@cdmadrid.com',
            'is_active' => true,
        ]);

        $school2 = SportsSchool::create([
            'name' => 'Escuela Deportiva Barcelona',
            'slug' => 'escuela-deportiva-barcelona',
            'description' => 'Centro deportivo especializado en formación integral',
            'address' => 'Passeig de Gràcia 456',
            'city' => 'Barcelona',
            'postal_code' => '08007',
            'phone' => '934567890',
            'email' => 'contacto@edbarcelona.com',
            'is_active' => true,
        ]);

        $this->command->info('✓ Escuelas deportivas de ejemplo creadas');

        // Crear usuarios para la primera escuela
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'admin@cdmadrid.com',
            'password' => Hash::make('password'),
            'sports_school_id' => $school1->id,
            'role' => 'school_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'coach@cdmadrid.com',
            'password' => Hash::make('password'),
            'sports_school_id' => $school1->id,
            'role' => 'coach',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Crear usuarios para la segunda escuela
        User::create([
            'name' => 'Carlos López',
            'email' => 'admin@edbarcelona.com',
            'password' => Hash::make('password'),
            'sports_school_id' => $school2->id,
            'role' => 'school_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('✓ Usuarios de ejemplo creados para las escuelas');
        $this->command->info('');
        $this->command->info('Credenciales de acceso:');
        $this->command->info('- Master: master@clubsportal.com / password');
        $this->command->info('- Admin Madrid: admin@cdmadrid.com / password');
        $this->command->info('- Coach Madrid: coach@cdmadrid.com / password');
        $this->command->info('- Admin Barcelona: admin@edbarcelona.com / password');
    }
}
