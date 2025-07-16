<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::factory(20)->create();

        foreach ($restaurants as $key => $restaurant) {
            $restaurant->addMedia($this->createFakeImage($restaurant->name))->toMediaCollection('image');
        }
    }
}
