<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SuperAdminMealController extends Controller
{
    /**
     * Display a listing of the meals for a specific restaurant.
     */
    public function index(Restaurant $restaurant)
    {
        $meals = $restaurant->meals()->with('category','media')->paginate(30);
        return view('admin.meals.index', compact('meals', 'restaurant'));
    }

    /**
     * Show the form for creating a new meal for a specific restaurant.
     */
    public function create(Restaurant $restaurant): View
    {
        $categories = $restaurant->categories;
        return view('admin.meals.create', compact('categories', 'restaurant'));
    }

    /**
     * Store a newly created meal in storage.
     */
    public function store(Request $request, Restaurant $restaurant): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set default value for is_available if not provided
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Add restaurant_id to the validated data
        $validated['restaurant_id'] = $restaurant->id;

        // Create the meal
        unset($validated['image']);
        $meal = Meal::create($validated);

        // Handle meal image if provided
        if ($request->hasFile('image')) {
            $meal->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.restaurants.meals.index', $restaurant->id)
            ->with('success', 'Meal created successfully');
    }

    /**
     * Show the form for editing the specified meal.
     */
    public function edit(Restaurant $restaurant, Meal $meal): View
    {
        // Ensure the meal belongs to the restaurant
        if ($meal->restaurant_id !== $restaurant->id) {
            abort(404, 'Meal not found in this restaurant');
        }

        $categories = $restaurant->categories;
        return view('admin.meals.edit', compact('meal', 'categories', 'restaurant'));
    }

    /**
     * Update the specified meal in storage.
     */
    public function update(Request $request, Restaurant $restaurant, Meal $meal): RedirectResponse
    {
        // Ensure the meal belongs to the restaurant
        if ($meal->restaurant_id !== $restaurant->id) {
            abort(404, 'Meal not found in this restaurant');
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Set default value for is_available if not provided
        $validated['is_available'] = $request->has('is_available') ? true : false;

        // Update the meal
        unset($validated['image']);
        $meal->update($validated);

        // Handle meal image if provided
        if ($request->hasFile('image')) {
            $meal->clearMediaCollection('image');
            $meal->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.restaurants.meals.index', $restaurant->id)
            ->with('success', 'Meal updated successfully');
    }

    /**
     * Remove the specified meal from storage.
     */
    public function destroy(Restaurant $restaurant, Meal $meal): RedirectResponse
    {
        // Ensure the meal belongs to the restaurant
        if ($meal->restaurant_id !== $restaurant->id) {
            abort(404, 'Meal not found in this restaurant');
        }

        // Delete the meal
        $meal->delete();

        return redirect()->route('admin.restaurants.meals.index', $restaurant->id)
            ->with('success', 'Meal deleted successfully');
    }
}
