<?php

namespace App\Console\Commands;

use App\Maintenance;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EditMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:edit-maintenance {maintenance : The id of the maintenance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modifies details of a maintenance';

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
        $maintenance = Maintenance::find($this->argument('maintenance'));

        if (!$maintenance) {
            $this->error('Maintenance not found.');
            return null;
        }

        $maintenance->title = $this->ask('What is the maintenance title?', $maintenance->title);
        $maintenance->description = $this->ask('What is the maintenance description?', $maintenance->description);

        $startIn = $this->ask('When does the maintenance start? (yyyy-mm-dd hh:mm, ' . config('statu.input-time-zone') . ')',
            Carbon::make($maintenance->start)->setTimezone(config('statu.input-time-zone'))->format('Y-m-d H:i'));
        $maintenance->start = Carbon::createFromFormat('Y-m-d H:i', $startIn, config('statu.input-time-zone'))->toIso8601String();

        $endIn = $this->ask('When does the maintenance end? (yyyy-mm-dd hh:mm, ' . config('statu.input-time-zone') . ')',
            Carbon::make($maintenance->scheduled_end)->setTimezone(config('statu.input-time-zone'))->format('Y-m-d H:i'));
        $maintenance->scheduled_end = Carbon::createFromFormat('Y-m-d H:i', $endIn, config('statu.input-time-zone'))->toIso8601String();

        $maintenance->save();

        return null;
    }
}
