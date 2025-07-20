<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantDashboardController extends Controller
{
    /**
     * Display the restaurant management page.
     */
    public function manage(): View
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        return view('restaurant.manage', compact('restaurant'));
    }

    /**
     * Update the restaurant information.
     */
    public function update(Request $request): RedirectResponse
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            abort(404, 'No restaurant found for this user');
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'type' => 'required|in:restaurant,shop_center',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update restaurant information
        unset($validated['image']);
        $restaurant->update($validated);

        // Handle restaurant image if provided
        if ($request->hasFile('image')) {
            $restaurant->clearMediaCollection('image');
            $restaurant->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('dashboard.restaurant')
            ->with('success', 'Restaurant information updated successfully');
    }
}
