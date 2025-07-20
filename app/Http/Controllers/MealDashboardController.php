<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealDashboardController extends Controller
{
    /**
     * Display the meals management page.
     */
    public function index(): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        $meals = $restaurant->meals()->with('category')->get();

        return view('restaurant.meals.index', compact('meals', 'restaurant'));
    }

    /**
     * Show the form for creating a new meal.
     */
    public function create(): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        $categories = $restaurant->categories;

        return view('restaurant.meals.create', compact('categories', 'restaurant'));
    }

    /**
     * Store a newly created meal in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
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

        return redirect()->route('dashboard.meals.index')
            ->with('success', 'Meal created successfully');
    }

    /**
     * Show the form for editing the specified meal.
     */
    public function edit(Meal $meal): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $meal->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
        }

        $categories = $restaurant->categories;

        return view('restaurant.meals.edit', compact('meal', 'categories', 'restaurant'));
    }

    /**
     * Update the specified meal in storage.
     */
    public function update(Request $request, Meal $meal): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $meal->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
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

        return redirect()->route('dashboard.meals.index')
            ->with('success', 'Meal updated successfully');
    }

    /**
     * Remove the specified meal from storage.
     */
    public function destroy(Meal $meal): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $meal->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
        }

        // Delete the meal
        $meal->delete();

        return redirect()->route('dashboard.meals.index')
            ->with('success', 'Meal deleted successfully');
    }
}
