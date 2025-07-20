<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Restaurant;
use App\Models\User;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminRestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants.
     */
    public function index(): View
    {
        $restaurants = Restaurant::with('admin')->get();
        return view('admin.restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new restaurant.
     */
    public function create(): View
    {
        return view('admin.restaurants.create');
    }

    /**
     * Store a newly created restaurant in storage.
     */
    public function store(StoreRestaurantRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create restaurant admin user
            $admin = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'phone' => $validated['admin_phone'],
                'password' => Hash::make($validated['admin_password']),
                'role' => UserRole::RestaurantAdmin->value,
            ]);

            // Remove admin fields from validated data
            $restaurantData = collect($validated)
                ->except(['admin_name', 'admin_email', 'admin_phone', 'admin_password', 'image'])
                ->toArray();

            // Create restaurant and associate with admin
            $restaurantData['user_id'] = $admin->id;
            $restaurant = Restaurant::create($restaurantData);

            // Handle restaurant image if provided
            if ($request->hasFile('image')) {
                $restaurant->addMediaFromRequest('image')
                    ->toMediaCollection('image');
            }

            DB::commit();

            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restaurant created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create restaurant: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified restaurant.
     */
    public function edit(Restaurant $restaurant): View
    {
        $restaurant->load('admin');
        return view('admin.restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified restaurant in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $validated = $request->validated();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update restaurant admin if admin data is provided
            $admin = $restaurant->admin;

            if ($admin && ($request->filled('admin_name') || $request->filled('admin_email') ||
                $request->filled('admin_phone') || $request->filled('admin_password'))) {

                $adminData = [];

                if ($request->filled('admin_name')) {
                    $adminData['name'] = $validated['admin_name'];
                }

                if ($request->filled('admin_email')) {
                    $adminData['email'] = $validated['admin_email'];
                }

                if ($request->filled('admin_phone')) {
                    $adminData['phone'] = $validated['admin_phone'];
                }

                if ($request->filled('admin_password')) {
                    $adminData['password'] = Hash::make($validated['admin_password']);
                }

                $admin->update($adminData);
            }

            // Remove admin fields from validated data
            $restaurantData = collect($validated)
                ->except(['admin_name', 'admin_email', 'admin_phone', 'admin_password', 'image'])
                ->toArray();

            // Update restaurant
            $restaurant->update($restaurantData);

            // Handle restaurant image if provided
            if ($request->hasFile('image')) {
                $restaurant->clearMediaCollection('image');
                $restaurant->addMediaFromRequest('image')
                    ->toMediaCollection('image');
            }

            DB::commit();

            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restaurant updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update restaurant: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified restaurant from storage.
     */
    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get the admin user associated with this restaurant
            $admin = $restaurant->admin;

            // Delete the restaurant (this will cascade delete related categories and meals)
            $restaurant->delete();

            // Delete the admin user if exists
            if ($admin) {
                $admin->delete();
            }

            DB::commit();

            return redirect()->route('admin.restaurants.index')
                ->with('success', 'Restaurant deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete restaurant: ' . $e->getMessage());
        }
    }
}
