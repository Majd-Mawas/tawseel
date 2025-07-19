<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $restaurant = Restaurant::inRandomOrder()->first();

        return [
            'name' => fake()->randomElement(
                $restaurant->type == 'restaurant' ? [
                    'مشاوي',
                    'مقبلات',
                    'أطباق رئيسية',
                    'شوربات',
                    'حلويات',
                    'فطور',
                    'سندويشات',
                    'أكلات شعبية',
                    'نباتي',
                    'مشروبات',
                ] : [
                    'مواد غذائية',
                    'ألبسة رجالية',
                    'ألبسة نسائية',
                    'ألبسة أطفال',
                    'إلكترونيات',
                    'مواد تنظيف',
                    'أدوات منزلية',
                    'عطور و مستحضرات',
                    'ألعاب أطفال',
                    'معلبات ومشروبات',
                ]
            ),
            'type' => $restaurant->type,
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id
        ];
    }
}
