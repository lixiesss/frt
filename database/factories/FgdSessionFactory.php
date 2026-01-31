<?php

namespace Database\Factories;

use App\Enums\FgdCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FgdSession>
 */
class FgdSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'schedule' => fake()->dateTimeBetween('now', '+2 weeks'),
            'place' => 'P.' . fake()->numberBetween(101, 707),
            'category' => fake()->randomElement(FgdCategory::cases()),
        ];
    }
}
