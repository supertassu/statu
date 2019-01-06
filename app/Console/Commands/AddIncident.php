<?php

namespace App\Console\Commands;

use App\Incident;
use Illuminate\Console\Command;

class AddIncident extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-incident';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Records a new incident to the system';

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
        $title = $this->ask('What is the incident title?');
        $desc = $this->ask('What is the incident description?');
        $affected = $this->choice('What components are affected?', array_keys(config('statu.components')), null, null, true);

        $incident = Incident::create([
            'title' => $title,
            'description' => $desc,
            'affected_components' => array_values($affected)
        ]);

        $this->info("Created incident $incident->id.");

        return null;
    }
}
