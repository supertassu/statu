<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class AddCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:add-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new category';

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
        $name = $this->ask('What is the category name?');

        $category = Category::create([
            'name' => $name
        ]);

        $this->info("Created category $category->id.");

        return null;
    }
}
