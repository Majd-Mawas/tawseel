<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index(): View
    {
        $drivers = User::where('role', UserRole::Driver->value)->get();
        return view('admin.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new driver.
     */
    public function create(): View
    {
        return view('admin.drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => ['required', Password::defaults()],
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create driver user
            $driverData = collect($validated)
                ->except(['image'])
                ->toArray();

            $driverData['role'] = UserRole::Driver->value;
            $driverData['password'] = Hash::make($validated['password']);

            $driver = User::create($driverData);

            // Handle driver image if provided
            if ($request->hasFile('image')) {
                $driver->addMediaFromRequest('image')
                    ->toMediaCollection('avatar');
            }

            DB::commit();

            return redirect()->route('admin.drivers.index')
                ->with('success', 'Driver created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create driver: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified driver.
     */
    public function edit(User $driver): View
    {
        // Ensure we're editing a driver
        if ($driver->role !== UserRole::Driver->value) {
            abort(404);
        }

        return view('admin.drivers.edit', compact('driver'));
    }

    /**
     * Update the specified driver in storage.
     */
    public function update(Request $request, User $driver): RedirectResponse
    {
        // Ensure we're updating a driver
        if ($driver->role !== UserRole::Driver->value) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $driver->id,
            'phone' => 'required|string|max:20',
            'password' => ['nullable', Password::defaults()],
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Update driver data
            $driverData = collect($validated)
                ->except(['password', 'image'])
                ->toArray();

            // Only update password if provided
            if ($request->filled('password')) {
                $driverData['password'] = Hash::make($validated['password']);
            }

            $driver->update($driverData);

            // Handle driver image if provided
            if ($request->hasFile('image')) {
                $driver->clearMediaCollection('avatar');
                $driver->addMediaFromRequest('image')
                    ->toMediaCollection('avatar');
            }

            DB::commit();

            return redirect()->route('admin.drivers.index')
                ->with('success', 'Driver updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update driver: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified driver from storage.
     */
    public function destroy(User $driver): RedirectResponse
    {
        // Ensure we're deleting a driver
        if ($driver->role !== UserRole::Driver->value) {
            abort(404);
        }

        try {
            // Delete the driver
            $driver->delete();

            return redirect()->route('admin.drivers.index')
                ->with('success', 'Driver deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete driver: ' . $e->getMessage());
        }
    }
}
