<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\SportsSchool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'sports_school_id' => SportsSchool::factory(),
            'user_id'          => null,
            'member_number'    => fake()->unique()->numerify('SOCIO-####'),
            'name'             => fake()->firstName(),
            'surname'          => fake()->lastName() . ' ' . fake()->lastName(),
            'dni'              => fake()->optional()->regexify('[0-9]{8}[A-Z]'),
            'email'            => fake()->optional()->safeEmail(),
            'phone'            => fake()->optional()->phoneNumber(),
            'birth_date'       => fake()->optional()->dateTimeBetween('-80 years', '-18 years'),
            'address'          => fake()->optional()->address(),
            'photo'            => null,
            'active'           => true,
        ];
    }

    public function withUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::factory(),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => ['active' => false]);
    }
}
