<?php

namespace Database\Seeders;

use App\Imports\ProductsImport;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class RestaurantSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Import data from Excel file
        Excel::import(new ProductsImport, storage_path('app/products.xlsx'));

        // Add images to all restaurants
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $restaurant->addMedia($this->createFakeImage($restaurant->name))->toMediaCollection('image');
        }
    }
}
