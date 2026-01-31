<?php

namespace Database\Factories;

use App\Models\FgdTopic;
use App\Models\FgdSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FgdGroup>
 */
class FgdGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Group ' . fake()->numberBetween(1, 10), 
            'mentor_name' => fake()->name(),
            'topic_id' => FgdTopic::factory(),
            'session_id' => FgdSession::factory(),
        ];
    }
}
