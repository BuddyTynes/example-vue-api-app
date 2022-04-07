<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicants;
use App\Models\Skills;
use App\Models\ApplicantSkill;

class applicant_skills extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $applicant_ids = Applicants::pluck('id')->toArray();
        $skill_ids = Skills::pluck('id')->toArray();

        foreach (range(1, 100) as $index) {
            $applicant_id = $faker->randomElement($applicant_ids);
            $skill_id = $faker->randomElement($skill_ids);
            ApplicantSkill::create([
                'applicant_id' => $applicant_id,
                'skill_id' => $skill_id,
            ]);
        }
    }
}
