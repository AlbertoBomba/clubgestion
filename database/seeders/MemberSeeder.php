<?php

namespace Database\Seeders;

use App\Enums\MemberPaymentStatus;
use App\Enums\MemberSeasonStatus;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\MemberSeason;
use App\Models\MemberType;
use App\Models\Season;
use App\Models\SportsSchool;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $school = SportsSchool::first();
        $season = Season::where('sports_school_id', $school?->id)->first();
        $types  = MemberType::where('sports_school_id', $school?->id)
                            ->where('season_id', $season?->id)
                            ->get();

        if (! $school || ! $season || $types->isEmpty()) {
            $this->command->warn('MemberSeeder: faltan datos previos. Ejecuta primero MemberTypeSeeder.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {
            $member = Member::create([
                'sports_school_id' => $school->id,
                'user_id'          => null,
                'member_number'    => 'SOCIO-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name'             => fake()->firstName(),
                'surname'          => fake()->lastName() . ' ' . fake()->lastName(),
                'email'            => fake()->safeEmail(),
                'phone'            => fake()->phoneNumber(),
                'active'           => true,
            ]);

            $type = $types->random();

            $memberSeason = MemberSeason::create([
                'member_id'      => $member->id,
                'season_id'      => $season->id,
                'member_type_id' => $type->id,
                'join_date'      => now()->startOfYear(),
                'leave_date'     => null,
                'price'          => $type->price,
                'payment_status' => MemberPaymentStatus::Pending->value,
                'status'         => MemberSeasonStatus::Active->value,
            ]);

            MemberPayment::create([
                'member_season_id' => $memberSeason->id,
                'amount'           => $type->price,
                'due_date'         => now()->addMonth(),
                'payment_date'     => null,
                'status'           => MemberPaymentStatus::Pending->value,
                'concept'          => 'Cuota ' . $type->name . ' ' . $season->season,
            ]);
        }

        $this->command->info('MemberSeeder: 10 socios de ejemplo creados correctamente.');
    }
}
