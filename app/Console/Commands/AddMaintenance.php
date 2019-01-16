<?php

namespace App\Console\Commands;

use App\Maintenance;
use App\Monitor;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Records a new maintenance window to the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $monitors = Monitor::all()->reduce(function ($monitors, $monitor) {
            $monitors[$monitor->id] = $monitor->id . ' ' . $monitor->name;
            return $monitors;
        });

        $title = $this->ask('What is the maintenance title?');
        $desc = $this->ask('What is the maintenance description?');
        $affected = $this->choice('What components are affected?', $monitors, null, null, true);

        $affected = array_values(array_map(function ($item) {
            return intval(explode(' ', $item)[0]);
        }, $affected));

        $startCorrect = false;
        $start = Carbon::now();

        while (!$startCorrect) {
            $startIn = $this->ask('When does the maintenance start? (yyyy-mm-dd hh:mm, ' . config('statu.input-time-zone') . ')');
            $start = Carbon::createFromFormat('Y-m-d H:i', $startIn, config('statu.input-time-zone'));

            if ($start) {
                $startCorrect = $this->confirm('Are you sure to set start time to ' . $start->format('l, d-M-y H:i:s T'), true);
            }
        }

        $endCorrect = false;
        $end = Carbon::now();

        while (!$endCorrect) {
            $endIn = $this->ask('When does the maintenance end? (yyyy-mm-dd hh:mm, ' . config('statu.input-time-zone') . ')');
            $end = Carbon::createFromFormat('Y-m-d H:i', $endIn, config('statu.input-time-zone'));

            if ($end) {
                $endCorrect = $this->confirm('Are you sure to set end time to ' . $end->format('l, d-M-y H:i:s T'), true);
            }
        }

        $maintenance = Maintenance::create([
            'title' => $title,
            'description' => $desc,
            'affected_components' => array_values($affected),
            'start' => $start->toIso8601String(),
            'scheduled_end' => $end->toIso8601String(),
            'closed' => false
        ]);

        $this->info("Created maintenance $maintenance->id.");

        return null;
    }
}
