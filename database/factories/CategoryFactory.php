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
        return [
            'name' => fake()->randomElement([
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
            ]),
            'name' => fake()->name(),
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id
        ];
    }
}
