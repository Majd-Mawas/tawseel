<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meals = Meal::factory(25)->create();

        foreach ($meals as $key => $meal) {
            $meal->addMedia($this->createFakeImage($meal->name))->toMediaCollection('image');
        }
    }
}
