<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();
        $meal_id = $order?->restaurant?->meals()?->inRandomOrder()?->first() ?? 1;

        return [
            'order_id' => $order->id,
            'meal_id' => $meal_id->id,
            'quantity' =>  fake()->numberBetween(1, 5),
            'price' => fake()->numberBetween(100, 500),
        ];
    }
}
