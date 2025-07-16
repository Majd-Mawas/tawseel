<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(OrderStatus::cases()),
            'total_price' => fake()->numberBetween(1000, 1500),
            'delivery_fee' => fake()->numberBetween(10, 50),
            'delivery_time_estimate' => fake()->numberBetween(10, 50),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ];
    }
}
