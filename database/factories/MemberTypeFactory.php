<?php

namespace Database\Factories;

use App\Enums\MemberPeriodicity;
use App\Models\MemberType;
use App\Models\Season;
use App\Models\SportsSchool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MemberType>
 */
class MemberTypeFactory extends Factory
{
    protected $model = MemberType::class;

    public function definition(): array
    {
        return [
            'sports_school_id' => SportsSchool::factory(),
            'season_id'        => Season::factory(),
            'name'             => fake()->randomElement(['Socio', 'Abonado', 'Empresa', 'Socio Protector', 'Juvenil']),
            'description'      => fake()->optional()->sentence(),
            'price'            => fake()->randomFloat(2, 30, 300),
            'periodicity'      => fake()->randomElement(MemberPeriodicity::cases())->value,
            'card_template'    => null,
            'active'           => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['active' => false]);
    }

    public function annual(): static
    {
        return $this->state(fn (array $attributes) => ['periodicity' => MemberPeriodicity::Annual->value]);
    }
}
