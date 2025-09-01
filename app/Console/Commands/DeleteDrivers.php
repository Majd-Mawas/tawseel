<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class DeleteDrivers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drivers:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all drivers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to delete all drivers...');

        $count = User::where('role', UserRole::Driver->value)->count();
        $this->info("Found {$count} drivers to delete");

        if ($count > 0) {
            // Confirm deletion
            if ($this->confirm('Are you sure you want to delete all drivers? This cannot be undone.')) {
                User::where('role', UserRole::Driver->value)->delete();
                $this->info('All drivers have been deleted successfully!');
            } else {
                $this->info('Operation cancelled.');
            }
        } else {
            $this->info('No drivers found to delete.');
        }

        return Command::SUCCESS;
    }
}
