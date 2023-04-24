<?php

namespace Database\Seeders;

use App\Models\Technology;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
      $tech_labels = ['Bootstrap', 'Tailwind', 'Vue', 'Laravel', 'Blade'];

      foreach($tech_labels as $tech_label) {
          $technology = new Technology();
          $technology->label = $tech_label;
          $technology->color = $faker->safeHexColor();
          $technology->save();
        }
    }
}