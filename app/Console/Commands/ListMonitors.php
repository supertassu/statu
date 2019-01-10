<?php

namespace App\Console\Commands;

use App\Monitor;
use Illuminate\Console\Command;

class ListMonitors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:list-monitors {category?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all monitors, possibly from specified category';

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
        if ($this->argument('category')) {
            $monitors = Monitor::whereCategoryId($this->argument('category'))->get()->toArray();
        } else {
            $monitors = Monitor::all()->toArray();
        }

        if (empty($monitors)) {
            $this->error('No monitors found.');
            return null;
        }

        $headers = ['ID', 'Name', 'Category ID'];
        $monitors = array_map(function($monitor) {
            return [
                'id' => $monitor['id'],
                'name' => $monitor['name'],
                'category' => $monitor['category_id']
            ];
        }, $monitors);

        $this->table($headers, $monitors);

        return null;
    }
}
