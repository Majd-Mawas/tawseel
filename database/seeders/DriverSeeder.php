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
        // Aleppo city center coordinates
        $aleppoCenter = [
            'latitude' => 36.2021,
            'longitude' => 37.1343
        ];

        // Define a radius (in degrees) to distribute drivers around Aleppo
        // Approximately 5km radius
        $radius = 0.045;

        // Create a test driver with known credentials
        User::factory()->driver()->create([
            'name' => 'driver-1',
            'email' => 'driver-1@driver.com',
            'password' => bcrypt('password'),
            'phone' => '+963 9' . rand(3, 5) . rand(1000000, 9999999), // Syrian mobile number format
            'latitude' => $aleppoCenter['latitude'] + (mt_rand(-100, 100) / 1000 * $radius),
            'longitude' => $aleppoCenter['longitude'] + (mt_rand(-100, 100) / 1000 * $radius),
        ]);

        // Create 5 random drivers
        for ($i = 2; $i <= 6; $i++) {
            User::factory()->driver()->create([
                'name' => 'driver-' . $i,
                'email' => 'driver-' . $i . '@driver.com',
                'phone' => '+963 9' . rand(3, 5) . rand(1000000, 9999999), // Syrian mobile number format
                'latitude' => $aleppoCenter['latitude'] + (mt_rand(-100, 100) / 1000 * $radius),
                'longitude' => $aleppoCenter['longitude'] + (mt_rand(-100, 100) / 1000 * $radius),
            ]);
        }
    }
}
