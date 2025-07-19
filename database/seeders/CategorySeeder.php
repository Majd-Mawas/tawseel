<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory(100)->create();

        foreach ($categories as $category) {
            $category->addMedia($this->createFakeImage($category->name))->toMediaCollection('image');
        }
    }
}
