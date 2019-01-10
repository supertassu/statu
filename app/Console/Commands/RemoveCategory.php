<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class RemoveCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statu:remove-category {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes a category by id';

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
        $categoryId = $this->argument('id');

        if (!$categoryId) {
            $categoryId = $this->ask('What is the category id?');
        }

        $category = Category::find($categoryId);

        if (!$category) {
            $this->error('Category not found.');
            return null;
        }

        if (!empty($category->monitors()->toArray())) {
            $this->error('Category has monitors.');
            return null;
        }

        if ($this->confirm('Would you like to delete category #' . $category->id . ' (' . $category->name . ')?')) {
            $category->delete();
            $this->info('Category deleted');
        } else {
            $this->warn('Category deletion cancelled');
        }

        return null;

    }
}
