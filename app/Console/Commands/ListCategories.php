<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class ListCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:list-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all categories';

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
        $headers = ['ID', 'Name'];
        $categories = Category::all(['id', 'name'])->toArray();

        // get rid of any other unnecessary columns
        $categories = array_map(function ($category) {
            return ['id' => $category['id'], 'name' => $category['name']];
        }, $categories);

        $this->table($headers, $categories);
    }
}
