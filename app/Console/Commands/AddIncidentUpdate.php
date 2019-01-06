<?php

namespace App\Console\Commands;

use App\Incident;
use App\IncidentUpdate;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddIncidentUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-incident-update {incident : The id of the incident}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an update for the incident';

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
        $incident = Incident::find($this->argument('incident'));

        if (!$incident) {
            $this->error('Incident not found.');
            return null;
        }

        $title = $this->ask('What is the update title?');
        $type = $this->choice('What is the update type?', $this->updateTypesSupported);
        $desc = $this->ask('What is the update description?');

        IncidentUpdate::create([
            'title' => $title,
            'description' => $desc,
            'incident_id' => $incident->id,
            'type' => $type
        ]);

        if ($type === 'solved') {
            $incident->resolved = Carbon::now()->toDateString();
        } else {
            $incident->resolved = null;
        }

        $incident->save();

        $this->info('Incident update created.');
        return null;
    }
}
