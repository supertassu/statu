<?php

use App\Incident;
use App\IncidentUpdate;
use Carbon\Carbon;
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

        $faker = \Faker\Factory::create();

        $incident = Incident::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'affected_components' => ['first', 'third', 'fifth']
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
            'resolved' => Carbon::now()->toDateString(),
            'affected_components' => ['first', 'third', 'fourth']
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

        IncidentUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'incident_id' => $incident->id,
            'type' => 'solved'
        ]);

        Incident::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'affected_components' => ['sixth']
        ]);
    }
}
