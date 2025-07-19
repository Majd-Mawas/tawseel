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
        return [
            'name' => fake()->randomElement([
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
            ]),
            'description' => fake()->sentence(),
            'phone' => fake()->phoneNumber(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
