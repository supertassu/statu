<?php

namespace App\Console\Commands;

use App\Monitor;
use Illuminate\Console\Command;

class RemoveMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:remove-monitor {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes a monitor by id';

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

        if (!$monitor) {
            $this->error('Monitor not found.');
            return null;
        }

        if ($this->confirm('Would you like to delete monitor #' . $monitor->id . ' (' . $monitor->name . ')?')) {
            $monitor->delete();
            $this->info('Monitor deleted');
        } else {
            $this->warn('Monitor deletion cancelled');
        }

        return null;

    }
}
