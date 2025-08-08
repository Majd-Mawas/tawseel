<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test driver with known credentials
        User::factory()->driver()->create([
            'name' => 'Test Driver',
            'email' => 'driver@driver.com',
            'password' => bcrypt('password'),
        ]);

        // Create 5 random drivers
        User::factory(5)->driver()->create();
    }
}
