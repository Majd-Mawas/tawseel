<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class DeleteCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to delete all categories...');

        $count = Category::count();
        $this->info("Found {$count} categories to delete");

        if ($count > 0) {
            // Confirm deletion
            if ($this->confirm('Are you sure you want to delete all categories? This cannot be undone.')) {
                Category::truncate();
                $this->info('All categories have been deleted successfully!');
            } else {
                $this->info('Operation cancelled.');
            }
        } else {
            $this->info('No categories found to delete.');
        }

        return Command::SUCCESS;
    }
}
