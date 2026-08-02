<?php

namespace Database\Factories;

use App\Enums\MemberPaymentStatus;
use App\Enums\MemberSeasonStatus;
use App\Models\Member;
use App\Models\MemberSeason;
use App\Models\MemberType;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberSeason>
 */
class MemberSeasonFactory extends Factory
{
    protected $model = MemberSeason::class;

    public function definition(): array
    {
        return [
            'member_id'      => Member::factory(),
            'season_id'      => Season::factory(),
            'member_type_id' => MemberType::factory(),
            'join_date'      => fake()->dateTimeBetween('-1 year', 'now'),
            'leave_date'     => null,
            'price'          => fake()->randomFloat(2, 30, 300),
            'payment_status' => MemberPaymentStatus::Pending->value,
            'status'         => MemberSeasonStatus::Active->value,
            'observations'   => fake()->optional()->sentence(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => MemberPaymentStatus::Paid->value,
        ]);
    }

    public function left(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'     => MemberSeasonStatus::Left->value,
            'leave_date' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
