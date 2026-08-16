<?php

namespace Database\Seeders;

use App\Enums\MemberPeriodicity;
use App\Models\MemberType;
use App\Models\Season;
use App\Models\SportsSchool;
use Illuminate\Database\Seeder;

class MemberTypeSeeder extends Seeder
{
    public function run(): void
    {
        $school = SportsSchool::first();
        $season = Season::where('sports_school_id', $school?->id)->first();

        if (! $school || ! $season) {
            $this->command->warn('MemberTypeSeeder: no se encontró SportsSchool o Season. Omitiendo.');
            return;
        }

        $types = [
            [
                'name'        => 'Socio',
                'description' => 'Socio estándar del club',
                'price'       => 60.00,
                'periodicity' => MemberPeriodicity::Annual->value,
            ],
            [
                'name'        => 'Abonado',
                'description' => 'Abonado con acceso a instalaciones',
                'price'       => 120.00,
                'periodicity' => MemberPeriodicity::Annual->value,
            ],
            [
                'name'        => 'Empresa',
                'description' => 'Socio corporativo o empresa patrocinadora',
                'price'       => 300.00,
                'periodicity' => MemberPeriodicity::Annual->value,
            ],
            [
                'name'        => 'Socio Protector',
                'description' => 'Socio protector con aportación especial',
                'price'       => 90.00,
                'periodicity' => MemberPeriodicity::Annual->value,
            ],
        ];

        foreach ($types as $type) {
            MemberType::firstOrCreate(
                [
                    'sports_school_id' => $school->id,
                    'season_id'        => $season->id,
                    'name'             => $type['name'],
                ],
                array_merge($type, [
                    'sports_school_id' => $school->id,
                    'season_id'        => $season->id,
                    'active'           => true,
                ])
            );
        }

        $this->command->info('MemberTypeSeeder:  Tarjetas de socio creadas correctamente.');
    }
}
