<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicants as ApplicantsModel;

class applicants extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        // create test applicants
        foreach (range(1, 20) as $index) {
            ApplicantsModel::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'created_by_id' => 1,
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at' => $faker->dateTimeBetween('-1 years', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 years', 'now'),
            ]);
        }
    }
}
