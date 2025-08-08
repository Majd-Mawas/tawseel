<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'role' => 'super_admin'
        ]);

        User::factory(10)->create();

        $this->call([
            RestaurantSeeder::class,
            CategorySeeder::class,
            MealSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            DriverSeeder::class,
        ]);
    }
}
