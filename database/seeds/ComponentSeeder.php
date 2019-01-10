<?php

use App\Category;
use App\Monitor;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Monitor::truncate();
        Category::truncate();

        $faker = Faker::create();

        for ($i = 0; $i < 6; $i++) {
            $category = Category::create([
                'name' => implode(' ', $faker->words(3))
            ]);

            for ($j = 0; $j < 5; $j++) {
                Monitor::create([
                    'category_id' => $category->id,
                    'name' => implode(' ', $faker->words(3))
                ]);
            }
        }
    }
}
