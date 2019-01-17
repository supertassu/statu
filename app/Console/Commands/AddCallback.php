<?php

namespace App\Console\Commands;

use App\Monitor;
use App\MonitorCallback;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddCallback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-monitor-callback {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new monitor callback';

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
        $monitorId = $this->argument('id');

        if (!$monitorId) {
            $monitorId = $this->ask('What is the monitor id?');
        }

        $monitor = Monitor::find($monitorId);

        $existing = MonitorCallback::where('monitor_id', $monitor->id)->first();
        
        if ($existing) {
            $this->error('A callback for the monitor ' . $monitor->name . ' already exists.');
            $this->info('The callback URL is: ' . $existing->url);
            return null;
        }

        $cb = MonitorCallback::create([
            'monitor_id' => $monitor->id,
            'key' => MonitorCallback::createKey(),
            'last_callback' => Carbon::now()->toIso8601String()
        ]);

        $this->info('Callback for monitor ' . $monitor->name . ' was created.');
        $this->info('The callback URL is: ' . $cb->url);

        return null;
    }
}
