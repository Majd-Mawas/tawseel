<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Restaurant;
use Illuminate\Console\Command;

class UpdateMealCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meals:update-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update meal categories based on ID ranges';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update meal categories...');

        // Define category ranges and their names
        $categoryRanges = [
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

        // Get all meals ordered by ID
        $meals = Meal::orderBy('id')->get();
        $this->info("Found {$meals->count()} meals to process");

        // Create a progress bar
        $bar = $this->output->createProgressBar($meals->count());
        $bar->start();

        // Track created categories to avoid duplicates
        $categories = [];

        foreach ($meals as $meal) {
            // Find the appropriate category based on meal ID
            $categoryName = 'منتجات'; // Default category name
            foreach ($categoryRanges as $range) {
                if ($meal->id >= $range[0] && $meal->id <= $range[1]) {
                    $categoryName = $range[2];
                    break;
                }
            }

            // Get or create category for this restaurant and category name
            $categoryKey = $meal->restaurant_id . '-' . $categoryName;
            if (!isset($categories[$categoryKey])) {
                $restaurant = Restaurant::find($meal->restaurant_id);

                if (!$restaurant) {
                    $this->warn("Restaurant not found for meal ID: {$meal->id}");
                    $bar->advance();
                    continue;
                }

                // Check if category already exists in database
                $category = Category::where('restaurant_id', $restaurant->id)
                    ->where('name', $categoryName)
                    ->first();

                if (!$category) {
                    // Create new category if it doesn't exist
                    $category = Category::create([
                        'restaurant_id' => $restaurant->id,
                        'name' => $categoryName,
                        'type' => $restaurant->type
                    ]);
                }

                $categories[$categoryKey] = $category;
            }

            // Update the meal with the new category
            $meal->update([
                'category_id' => $categories[$categoryKey]->id
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Meal categories have been updated successfully!');

        return Command::SUCCESS;
    }
}
