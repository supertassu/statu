<?php

use App\Incident;
use App\IncidentUpdate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Incident::truncate();
        IncidentUpdate::truncate();

        $faker = Faker::create();

        $incident = Incident::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'affected_components' => [1, 2, 3, 4, 5]
        ]);

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'monitoring'
        ]);

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'update'
        ]);

        $incident = Incident::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'affected_components' => [9, 11, 16, 17, 18, 19, 20]
        ]);

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'update'
        ]);

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'investigating'
        ]);

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'monitoring'
        ]);
    }
}
