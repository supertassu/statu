<?php

namespace App\Console\Commands;

use App\Category;
use App\Monitor;
use Illuminate\Console\Command;

class AddMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-monitor {category?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new monitor';

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
        $categoryId = $this->argument('category');

        if (!$categoryId) {
            $categoryId = $this->ask('What is the category id?');
        }

        $category = Category::find($categoryId);

        if (!$category) {
            $this->error('Category not found.');
            return null;
        }

        $name = $this->ask('What is the monitor name?');

        $monitor = Monitor::create([
            'name' => $name,
            'category_id' => $category->id
        ]);

        $this->info("Created monitor $monitor->id.");

        return null;
    }
}
