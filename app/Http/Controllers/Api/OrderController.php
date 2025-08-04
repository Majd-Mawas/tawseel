<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
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

            $order = \App\Models\Order::create([
                'restaurant_id' => $validated['center_id'],
                'user_id' => $user->id,
                'status' => \App\Enums\OrderStatus::Pending,
                'total_price' => $totalPrice,
                'delivery_fee' => $deliveryFee,
                'delivery_time_estimate' => $deliveryTimeEstimate,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            $order->refresh()->load(['items.meal', 'restaurant']);


            return $this->successResponse($order, 'Order placed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to place order: ' . $e->getMessage(), 500);
        }
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
}
