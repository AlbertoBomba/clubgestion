<?php

namespace Database\Factories;

use App\Enums\MemberPaymentStatus;
use App\Models\MemberPayment;
use App\Models\MemberSeason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberPayment>
 */
class MemberPaymentFactory extends Factory
{
    protected $model = MemberPayment::class;

    public function definition(): array
    {
        return [
            'member_season_id' => MemberSeason::factory(),
            'amount'           => fake()->randomFloat(2, 20, 200),
            'due_date'         => fake()->dateTimeBetween('now', '+3 months'),
            'payment_date'     => null,
            'status'           => MemberPaymentStatus::Pending->value,
            'concept'          => fake()->randomElement(['Cuota anual', 'Cuota mensual', 'Cuota trimestral', 'Carnet de socio']),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'       => MemberPaymentStatus::Paid->value,
            'payment_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status'   => MemberPaymentStatus::Pending->value,
            'due_date' => fake()->dateTimeBetween('-6 months', '-1 day'),
        ]);
    }
}
