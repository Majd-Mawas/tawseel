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
    private $categoryRanges = [];
    private $mealCount = 0;

    // Aleppo city center coordinates
    private $aleppoCenter = [
        'latitude' => 36.2021,
        'longitude' => 37.1343
    ];

    // Define a radius (in degrees) to distribute restaurants around Aleppo
    // Approximately 5km radius
    private $radius = 0.045;

    public function __construct()
    {
        // Define category ranges and their names
        $this->categoryRanges = [
            // First set
            [1, 8, 'مفرزات'],
            [9, 23, 'لحم'],
            [24, 90, 'بقوليات'],
            [91, 114, 'مخبوزات وكاتو'],
            [115, 284, 'بسكويت'],
            [285, 320, 'مشروبات غازية'],
            [321, 330, 'حليب كريمة'],
            [331, 352, 'حواضر البيت'],
            [353, 392, 'بقوليات'],
            [393, 432, 'شاي وقهوة'],
            [433, 447, 'باستا'],
            [448, 479, 'بقوليات'],
            [480, 564, 'عناية شخصية + منظفات'],
            [565, 574, 'توابل'],
            [575, 588, 'كورن فلكس'],
            [579, 637, 'تسالي ومقرمشات'],
            [638, 707, 'معلبات'],

            // Second set
            [708, 715, 'مفرزات'],
            [716, 730, 'لحم'],
            [731, 797, 'بقوليات'],
            [798, 821, 'مخبوزات وكاتو'],
            [822, 991, 'بسكويت'],
            [992, 1027, 'مشروبات غازية'],
            [1028, 1037, 'حليب كريمة'],
            [1038, 1059, 'حواضر البيت'],
            [1060, 1099, 'بقوليات'],
            [1100, 1139, 'شاي وقهوة'],
            [1140, 1154, 'باستا'],
            [1155, 1186, 'بقوليات'],
            [1187, 1271, 'عناية شخصية + منظفات'],
            [1272, 1281, 'توابل'],
            [1282, 1295, 'كورن فلكس'],
            [1286, 1344, 'تسالي ومقرمشات'],
            [1345, 1414, 'معلبات'],

            // Third set
            [1415, 1422, 'مفرزات'],
            [1423, 1437, 'لحم'],
            [1438, 1504, 'بقوليات'],
            [1505, 1528, 'مخبوزات وكاتو'],
            [1529, 1698, 'بسكويت'],
            [1699, 1734, 'مشروبات غازية'],
            [1735, 1744, 'حليب كريمة'],
            [1745, 1766, 'حواضر البيت'],
            [1767, 1806, 'بقوليات'],
            [1807, 1846, 'شاي وقهوة'],
            [1847, 1861, 'باستا'],
            [1862, 1893, 'بقوليات'],
            [1894, 1978, 'عناية شخصية + منظفات'],
            [1979, 1988, 'توابل'],
            [1989, 2002, 'كورن فلكس'],
            [1993, 2051, 'تسالي ومقرمشات'],
            [2052, 2121, 'معلبات'],

            // Fourth set
            [2122, 2129, 'مفرزات'],
            [2130, 2144, 'لحم'],
            [2145, 2211, 'بقوليات'],
            [2212, 2235, 'مخبوزات وكاتو'],
            [2236, 2405, 'بسكويت'],
            [2406, 2441, 'مشروبات غازية'],
            [2442, 2451, 'حليب كريمة'],
            [2452, 2473, 'حواضر البيت'],
            [2474, 2513, 'بقوليات'],
            [2514, 2553, 'شاي وقهوة'],
            [2554, 2568, 'باستا'],
            [2569, 2600, 'بقوليات'],
            [2601, 2685, 'عناية شخصية + منظفات'],
            [2686, 2695, 'توابل'],
            [2696, 2709, 'كورن فلكس'],
            [2700, 2758, 'تسالي ومقرمشات'],
            [2759, 2828, 'معلبات'],

            // Fifth set
            [2829, 2836, 'مفرزات'],
            [2837, 2851, 'لحم'],
            [2852, 2918, 'بقوليات'],
            [2919, 2942, 'مخبوزات وكاتو'],
            [2943, 3112, 'بسكويت'],
            [3113, 3148, 'مشروبات غازية'],
            [3149, 3158, 'حليب كريمة'],
            [3159, 3180, 'حواضر البيت'],
            [3181, 3220, 'بقوليات'],
            [3221, 3260, 'شاي وقهوة'],
            [3261, 3275, 'باستا'],
            [3276, 3307, 'بقوليات'],
            [3308, 3392, 'عناية شخصية + منظفات'],
            [3393, 3402, 'توابل'],
            [3403, 3416, 'كورن فلكس'],
            [3407, 3465, 'تسالي ومقرمشات'],
            [3466, 3535, 'معلبات'],

            // Sixth set
            [3536, 3543, 'مفرزات'],
            [3544, 3558, 'لحم'],
            [3559, 3625, 'بقوليات'],
            [3626, 3649, 'مخبوزات وكاتو'],
            [3650, 3819, 'بسكويت'],
            [3820, 3855, 'مشروبات غازية'],
            [3856, 3865, 'حليب كريمة'],
            [3866, 3887, 'حواضر البيت'],
            [3888, 3927, 'بقوليات'],
            [3928, 3967, 'شاي وقهوة'],
            [3968, 3982, 'باستا'],
            [3983, 4014, 'بقوليات'],
            [4015, 4099, 'عناية شخصية + منظفات'],
            [4100, 4109, 'توابل'],
            [4110, 4123, 'كورن فلكس'],
            [4114, 4172, 'تسالي ومقرمشات'],
            [4173, 4242, 'معلبات'],
        ];
    }

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
                    'type' => collect(['restaurant', 'shop_center'])->random()
                ]);

                $this->restaurants[$row['shop_name']] = $restaurant;
            }

            $restaurant = $this->restaurants[$row['shop_name']];

            // Increment meal count for category assignment
            $this->mealCount++;

            // Find the appropriate category based on meal count
            $categoryName = 'منتجات'; // Default category name
            foreach ($this->categoryRanges as $range) {
                if ($this->mealCount >= $range[0] && $this->mealCount <= $range[1]) {
                    $categoryName = $range[2];
                    break;
                }
            }

            // Get or create category for this restaurant and category name
            $categoryKey = $restaurant->id . '-' . $categoryName;
            if (!isset($this->categories[$categoryKey])) {
                $category = Category::factory()->create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $categoryName,
                    'type' => $restaurant->type
                ]);

                $this->categories[$categoryKey] = $category;
            }

            $category = $this->categories[$categoryKey];

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
