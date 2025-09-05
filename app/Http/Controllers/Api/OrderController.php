<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function checkout(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'center_id' => 'required|exists:restaurants,id',
            'items' => 'required|array',
            'items.*.meal_id' => 'required|exists:meals,id',
            'items.*.quantity' => 'required|integer|min:1',
            'latitude' => 'required|numeric', // Make these required for delivery calculation
            'longitude' => 'required|numeric',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get the restaurant
            $restaurant = \App\Models\Restaurant::findOrFail($validated['center_id']);

            // Calculate distance between restaurant and customer
            $distance = $this->calculateDistance(
                $restaurant->latitude,
                $restaurant->longitude,
                $validated['latitude'],
                $validated['longitude']
            );

            $deliveryFee = 5 + ($distance * 2);

            $deliveryFee = round($deliveryFee);

            $deliveryTimeEstimate = 15 + ($distance * 5);

            $deliveryTimeEstimate = round($deliveryTimeEstimate);

            $totalPrice = 0;
            $items = [];

            foreach ($validated['items'] as $item) {
                $meal = \App\Models\Meal::findOrFail($item['meal_id']);
                $price = $meal->price * $item['quantity'];
                $totalPrice += $price;

                $items[] = [
                    'meal_id' => $meal->id,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];
            }
            $restaurant = Restaurant::findOrFail($validated['center_id']);
            $order = \App\Models\Order::create([
                'restaurant_id' => $validated['center_id'],
                'user_id' => $user->id,
                'status' => OrderStatus::Pending,
                'total_price' => $totalPrice,
                'delivery_fee' => $deliveryFee,
                'delivery_time_estimate' => $deliveryTimeEstimate,
                'longitude' => $validated['longitude'],
                'latitude' => $validated['latitude'],
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // Find and assign the nearest available driver
            $nearestDriver = $this->findNearestDriver($order, $restaurant->longitude, $restaurant->latitude);

            if ($nearestDriver) {
                // Assign the order to the driver and update status
                $order->driver_id = $nearestDriver->id;
                $order->status = OrderStatus::OnTheWay;
                $order->save();
            }

            DB::commit();

            $order->refresh()->load(['items.meal', 'restaurant', 'driver']);

            return $this->successResponse($order, 'Order placed successfully' .
                ($nearestDriver ? ' and assigned to driver' : ''));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to place order: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Find the nearest available driver to an order
     */
    private function findNearestDriver(Order $order, $longitude, $latitude)
    {
        // Get all available drivers (users with driver role)
        $drivers = User::where('role', UserRole::Driver->value)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        if ($drivers->isEmpty()) {
            return null;
        }

        $nearestDriver = null;
        $shortestDistance = PHP_FLOAT_MAX;

        foreach ($drivers as $driver) {
            // Calculate distance between driver and order delivery location
            $distance = $this->calculateDistance(
                $driver->latitude,
                $driver->longitude,
                $latitude,
                $longitude
            );

            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $nearestDriver = $driver;
            }
        }

        return $nearestDriver;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Earth's radius in kilometers
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Order $order, Request $request)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== $request->user()->id) {
            return $this->errorResponse('You are not authorized to cancel this order', 403);
        }

        // // Check if the order can be cancelled (only pending or preparing orders can be cancelled)
        // if (!in_array($order->status, [OrderStatus::Pending->value, OrderStatus::Preparing->value])) {
        //     return $this->errorResponse('This order cannot be cancelled', 400);
        // }

        try {
            // Update the order status to cancelled
            $order->status = OrderStatus::Cancelled;
            $order->save();

            return $this->successResponse($order, 'Order cancelled successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to cancel order: ' . $e->getMessage(), 500);
        }
    }
}
