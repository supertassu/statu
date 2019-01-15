<?php

namespace App\Console\Commands;

use App\Monitor;
use Illuminate\Console\Command;

class SetMonitorStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:set-monitor-status {id?} {status?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the status of a monitor';

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

        if (!$monitor) {
            $this->error('Monitor not found.');
            return null;
        }

        if ($this->argument('status')) {
            $status = filter_var($this->argument('status'), FILTER_VALIDATE_BOOLEAN);
        } else {
            $status = $this->confirm('What should be the new status of the monitor?');
        }

        $monitor->last_status = $status;
        $monitor->save();

        $statusStr = $monitor->last_status ? 'true' : 'false';
        $this->info('Set last status of monitor ' . $monitor->name . ' to ' . $statusStr . '.');

        return null;
    }
}
