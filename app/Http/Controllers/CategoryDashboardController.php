<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryDashboardController extends Controller
{
    /**
     * Display the categories management page.
     */
    public function index(): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        $categories = $restaurant->categories;

        return view('restaurant.categories.index', compact('categories', 'restaurant'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        return view('restaurant.categories.create', compact('restaurant'));
    }

    /**
     * Store a newly created category in storage.
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
            'type' => 'required|in:restaurant,shop_center',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Add restaurant_id to the validated data
        $validated['restaurant_id'] = $restaurant->id;

        // Create the category
        unset($validated['image']);
        $category = Category::create($validated);

        // Handle category image if provided
        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
        }

        return view('restaurant.categories.edit', compact('category', 'restaurant'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:restaurant,shop_center',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the category
        unset($validated['image']);
        $category->update($validated);

        // Handle category image if provided
        if ($request->hasFile('image')) {
            $category->clearMediaCollection('image');
            $category->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant || $category->restaurant_id !== $restaurant->id) {
            abort(403, 'Unauthorized action');
        }

        // Check if category has meals
        if ($category->meals()->count() > 0) {
            return redirect()->route('dashboard.categories.index')
                ->with('error', 'Cannot delete category with associated meals');
        }

        // Delete the category
        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
