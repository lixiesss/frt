<?php

namespace Database\Seeders;

use App\Enums\Department;
use App\Enums\FgdCategory;
use App\Enums\Gender;
use App\Enums\Major;
use App\Models\Admin;
use App\Models\Applicant;
use App\Models\FgdGroup;
use App\Models\FgdSession;
use App\Models\FgdTopic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Roosevelt',
            'email' => 'c14230210@john.petra.ac.id',
            'department' => Department::IS,
            'major' => Major::IF,
        ]);

        Applicant::create([
            'name' => 'Roosevelt',
            'nrp' => 'c14230210',
            'major' => Major::IF,
            'gpa' => 3.90,
            'gender' => Gender::MALE,
            'visi' => 'visi',
            'misi' => 'misi',
            'value' => 'IMPACT',
            'stage' => 0,
            'first_choice_department' => Department::IS,
            'first_choice_motivation' => 'Motivasi',
            'first_choice_commitment' => 'Komitmen',
            'second_choice_department' => Department::CNB,
            'second_choice_motivation' => 'Motivasi',
            'second_choice_commitment' => 'Komitmen',
            'requires_coding_test' => false,
            'is_draft' => false,
        ]);

        Applicant::factory(50)->create();

        $topics = FgdTopic::factory(5)->create();
        $sessions = FgdSession::factory(3)->create();
        FgdGroup::factory()->count(10)
            ->sequence(fn ($sequence) => [
                'name' => 'Group ' . ($sequence->index + 1),
                'topic_id' => $topics->random()->id,
                'session_id' => $sessions->random()->id,
            ])
            ->create();
    }
}
