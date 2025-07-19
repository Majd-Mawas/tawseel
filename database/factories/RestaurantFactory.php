<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['restaurant', 'shop_center']);

        return [
            'name' => fake()->randomElement(
                $type == 'restaurant' ? [
                    'مطعم بيت المأكولات',
                    'البيت الدمشقي',
                    'الشام العتيقة',
                    'مطعم أبو خليل',
                    'بيت الكباب',
                    'ليالي الشام',
                    'الركن الحلبي',
                    'القلعة للمأكولات الشرقية',
                    'مطعم ورد الشام',
                    'مطعم النخيل',
                    'دار الزيتون',
                    'مذاق الشام',
                    'مندي السلطان',
                    'مطعم باب توما',
                    'زاوية الطيبين',
                    'بيت العز',
                    'مطعم زمزم',
                    'كبابجي حلب',
                    'مطعم الياسمين الدمشقي',
                    'فلافل السلطان',
                ] : [
                    'مركز الشام للتسوق',
                    'بازار الشرق',
                    'مول حلب',
                    'سوق الخير',
                    'مركز النخبة التجاري',
                    'مول المدينة',
                    'تسوق بلاس',
                    'أسواق الراحة',
                    'مول السعادة',
                    'مجمع التوفير',
                    'سوق الأسرة',
                    'المركز العصري',
                    'بازار الراوي',
                    'مول قاسيون',
                    'سوق زمان',
                ]
            ),
            'description' => fake()->sentence(),
            'phone' => fake()->phoneNumber(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => $type,
        ];
    }
}
