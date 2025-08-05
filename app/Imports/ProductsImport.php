<?php

namespace App\Imports;

use App\Models\Meal;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection, WithHeadingRow
{
    private $restaurants = [];
    private $categories = [];

    // Aleppo city center coordinates
    private $aleppoCenter = [
        'latitude' => 36.2021,
        'longitude' => 37.1343
    ];

    // Define a radius (in degrees) to distribute restaurants around Aleppo
    // Approximately 5km radius
    private $radius = 0.045;

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip if required fields are missing
            if (empty($row['shop_name']) || empty($row['product_name']) || empty($row['product_price'])) {
                continue;
            }

            // Get or create restaurant
            if (!isset($this->restaurants[$row['shop_name']])) {
                $user = User::factory()->create([
                    'role' => 'restaurant_admin',
                    'email' => 'shop-' . count($this->restaurants) . '@email.com'
                ]);

                // Generate random coordinates within Aleppo city boundaries
                $angle = mt_rand(0, 360) * (pi() / 180); // Random angle in radians
                $distance = mt_rand(0, 100) / 100 * $this->radius; // Random distance within radius

                // Calculate new coordinates
                $latitude = $this->aleppoCenter['latitude'] + ($distance * cos($angle));
                $longitude = $this->aleppoCenter['longitude'] + ($distance * sin($angle));

                $restaurant = Restaurant::factory()->create([
                    'name' => $row['shop_name'],
                    'user_id' => $user->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'type' => 'restaurant' // Assuming all are restaurants
                ]);

                $this->restaurants[$row['shop_name']] = $restaurant;
            }

            $restaurant = $this->restaurants[$row['shop_name']];

            // Get or create a default category for this restaurant
            if (!isset($this->categories[$restaurant->id])) {
                $category = Category::factory()->create([
                    'restaurant_id' => $restaurant->id,
                    'name' => 'منتجات', // Default category name
                    'type' => $restaurant->type
                ]);

                $this->categories[$restaurant->id] = $category;
            }

            $category = $this->categories[$restaurant->id];

            // Create the meal/product
            $meal = Meal::factory()->create([
                'name' => $row['product_name'],
                'price' => $row['product_price'],
                'restaurant_id' => $restaurant->id,
                'category_id' => $category->id,
                'description' => $row['product_name'] . ' - ' . $row['shop_name']
            ]);
        }
    }
}
