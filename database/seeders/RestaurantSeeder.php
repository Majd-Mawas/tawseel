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
        for ($i = 1; $i <= 20; $i++) {
            $restaurants[] = Restaurant::factory()->create([
                'user_id' => User::factory()->create([
                    'role' => 'restaurant_admin',
                    'email' => 'restaurant-' . $i . '@email.com'
                ])
            ]);
        }

        foreach ($restaurants as $restaurant) {
            $restaurant->addMedia($this->createFakeImage($restaurant['name']))->toMediaCollection('image');
        }
    }
}
