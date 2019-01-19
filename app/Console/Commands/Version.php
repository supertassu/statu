<?php

namespace App\Console\Commands;

use App\ApplicationVersion;
use Illuminate\Console\Command;

class Version extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the Statu version';

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
        $version = ApplicationVersion::instance();
        $this->info($version->get());

        return null;
    }
}
