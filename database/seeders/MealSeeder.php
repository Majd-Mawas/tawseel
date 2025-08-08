<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $meals = Meal::all();

        foreach ($meals as $meal) {
            $meal->addMedia($this->createFakeImage($meal->name))->toMediaCollection('image');
        }
    }
}
