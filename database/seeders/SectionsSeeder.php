<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\SportsSchool;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear secciones genéricas (no asociadas a escuelas específicas)
        $sections = [
            ['name' => 'Fútbol', 'description' => 'Sección de fútbol'],
            ['name' => 'Pádel', 'description' => 'Sección de pádel'],
            ['name' => 'Tenis', 'description' => 'Sección de tenis'],
            ['name' => 'Baloncesto', 'description' => 'Sección de baloncesto'],
            ['name' => 'Voleibol', 'description' => 'Sección de voleibol'],
            ['name' => 'Natación', 'description' => 'Sección de natación'],
            ['name' => 'Atletismo', 'description' => 'Sección de atletismo'],
            ['name' => 'Gimnasia', 'description' => 'Sección de gimnasia'],
            ['name' => 'Artes Marciales', 'description' => 'Sección de artes marciales'],
            ['name' => 'Hockey', 'description' => 'Sección de hockey'],
        ];

        foreach ($sections as $section) {
            Section::firstOrCreate([
                'name' => $section['name'],
            ], [
                'description' => $section['description'],
                'active' => true,
                'created_user' => 1,
            ]);
        }

        $this->command->info('Secciones genéricas creadas correctamente');
    }
}
