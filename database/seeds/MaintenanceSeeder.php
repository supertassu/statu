<?php

use App\Maintenance;
use App\MaintenanceUpdate;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Maintenance::truncate();

        $faker = Faker::create();
        
        $maintenance = Maintenance::create([
            'title' => implode(' ', $faker->words(2)),
            'description' => $faker->paragraph,
            'affected_components' => [6, 7, 8, 10],
            'start' => Carbon::now()->subMinutes(15)->toIso8601String(),
            'scheduled_end' => Carbon::now()->addMinutes(30)->toIso8601String(),
            'closed' => false
        ]);

        MaintenanceUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'maintenance_id' => $maintenance->id,
            'type' => 'update'
        ]);

        MaintenanceUpdate::create([
            'title' => $faker->sentence,
            'description' => $faker->paragraph,
            'maintenance_id' => $maintenance->id,
            'type' => 'monitoring'
        ]);

    }
}
