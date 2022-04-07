<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skills as SkillsModel;

class skills extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $skills = ['laravel', 'composer', 'MVC', 'PHP', 'JavaScript', 'jQuery', 'JSON', 'AJAX', 'Bootstrap', 'HTML', 'CSS', 'Git', 'Terminal', 'Vagrant', 'MySQL', 'Apache', 'LAMP'];
        
        foreach (range(1, 17) as $index) {
            $skill = $faker->randomElement($skills);
            SkillsModel::create([
                'name' => $skill,
            ]);
        }
    }
}
