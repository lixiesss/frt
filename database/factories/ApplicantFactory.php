<?php

namespace Database\Factories;

use App\Enums\Major;
use App\Enums\Gender;
use App\Enums\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nrp' => 'c1425' . sprintf('%04d', fake()->unique()->numberBetween(1, 200)),
            'major' => fake()->randomElement(Major::cases()),
            'gpa' => fake()->randomFloat(2, 2.75, 4.00),
            'gender' => fake()->randomElement(Gender::cases()),
            'visi' => fake()->sentence(),
            'misi' => fake()->paragraph(),
            'value' => 'IMPACT',
            'stage' => fake()->numberBetween(0, 3), 
            'first_choice_department' => fake()->randomElement(Department::cases()),
            'first_choice_motivation' => fake()->paragraph(2),
            'first_choice_commitment' => fake()->paragraph(2),
            'second_choice_department' => fake()->randomElement(Department::cases()),
            'second_choice_motivation' => fake()->paragraph(2),
            'second_choice_commitment' => fake()->paragraph(2),
            'requires_coding_test' => fake()->boolean(20),
            'is_draft' => false,
        ];
    }
}
