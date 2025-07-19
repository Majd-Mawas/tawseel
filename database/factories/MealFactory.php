<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $restaurant = $category->restaurant;

        return [
            'name' => fake()->randomElement(
                $category->type == 'restaurant' ? [
                    'كبة مقلية',
                    'كبة لبنية',
                    'محشي كوسا وورق عنب',
                    'شيش طاووق',
                    'شاورما لحم',
                    'شاورما دجاج',
                    'فتة حمص',
                    'يبرق',
                    'يخنة فاصوليا',
                    'مجدرة',
                    'كباب حلبي',
                    'كفتة بالصينية',
                    'كوارع',
                    'مقلوبة',
                    'رز بشعيرية',
                    'مسقعة',
                    'صفيحة شامية',
                    'فلافل',
                    'فريكة مع دجاج',
                    'عرايس لحم',
                ] : [
                    'شاي أخضر',
                    'مكسرات مشكلة',
                    'كوب حراري',
                    'شاحن موبايل',
                    'زيت زيتون بلدي',
                    'صابون غار',
                    'ماء معطر',
                    'علبة شوكولا',
                    'محارم معطرة',
                    'منظف متعدد الاستخدام',
                    'سماعات بلوتوث',
                    'مروحة صغيرة',
                ]
            ),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 500),
            'is_available' => true,
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id
        ];
    }
}
