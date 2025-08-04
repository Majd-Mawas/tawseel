<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends BaseSeeder
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

        // Define a radius (in degrees) to distribute restaurants around Aleppo
        // Approximately 5km radius
        $radius = 0.045;

        $restaurants = [];

        for ($i = 1; $i <= 20; $i++) {
            // Generate random coordinates within Aleppo city boundaries
            $angle = mt_rand(0, 360) * (pi() / 180); // Random angle in radians
            $distance = mt_rand(0, 100) / 100 * $radius; // Random distance within radius

            // Calculate new coordinates
            $latitude = $aleppoCenter['latitude'] + ($distance * cos($angle));
            $longitude = $aleppoCenter['longitude'] + ($distance * sin($angle));

            // Create restaurant with Aleppo coordinates
            $restaurants[] = Restaurant::factory()->create([
                'user_id' => User::factory()->create([
                    'role' => 'restaurant_admin',
                    'email' => 'center-' . $i . '@email.com'
                ]),
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        }

        foreach ($restaurants as $restaurant) {
            $restaurant->addMedia($this->createFakeImage($restaurant['name']))->toMediaCollection('image');
        }
    }
}
