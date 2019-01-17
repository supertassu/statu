<?php

namespace App\Console\Commands;

use App\Monitor;
use App\MonitorCallback;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckHeartbeats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:check-heartbeats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for all heartbeats';

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
        $callbacks = MonitorCallback::all();

        foreach ($callbacks as $callback) {
            $lastPing = Carbon::make($callback->last_callback);
            $tenMinutesAge = Carbon::now()->subtract(10, 'minutes');
            $online = $lastPing->isAfter($tenMinutesAge);

            /** @var Monitor $monitor */
            $monitor = $callback->getMonitor();
            $monitor->last_status = $online;
            $monitor->save();
        }

        return null;
    }
}
