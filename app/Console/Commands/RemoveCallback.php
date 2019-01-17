<?php

namespace App\Console\Commands;

use App\Monitor;
use App\MonitorCallback;
use Illuminate\Console\Command;

class RemoveCallback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:remove-monitor-callback {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes a callback by monitor id';

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
     * @throws \Exception
     */
    public function handle()
    {
        $monitorId = $this->argument('id');

        if (!$monitorId) {
            $monitorId = $this->ask('What is the monitor id?');
        }

        $monitor = Monitor::find($monitorId);

        $callback = MonitorCallback::where('monitor_id', $monitor->id)->first();

        if (!$callback) {
            $this->error('No callback found.');
            return null;
        }

        $callback->delete();

        $monitor->last_status = true;
        $monitor->save();

        $this->info('Callback successfully removed');

        return null;
    }
}
