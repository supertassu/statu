<?php

namespace App\Console\Commands;

use App\Maintenance;
use App\MaintenanceUpdate;
use Illuminate\Console\Command;

class AddMaintenanceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-maintenance-update {maintenance : The id of the maintenance}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an update for the maintenance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $updateTypesSupported = [
        'update', 'monitoring', 'investigating', 'solved', 're-opened'
    ];

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

        $title = $this->ask('What is the update title?');
        $type = $this->choice('What is the update type?', $this->updateTypesSupported, 'update');
        $desc = $this->ask('What is the update description?');

        MaintenanceUpdate::create([
            'title' => $title,
            'description' => $desc,
            'maintenance_id' => $maintenance->id,
            'type' => $type
        ]);

        $maintenance->closed = $type === 'solved';
        $maintenance->save();

        $this->info('Maintenance update created.');
        return null;
    }
}
