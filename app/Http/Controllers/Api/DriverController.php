<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    use ApiResponse;

    /**
     * Get available orders for drivers
     */
    public function availableOrders()
    {
        // Check if user is a driver
        if (Auth::user()->role !== UserRole::Driver->value) {
            return $this->errorResponse('Unauthorized. Driver access required.', 403);
        }

        // Get orders that are pending and have no driver assigned
        $orders = Order::whereNull('driver_id')
            ->where('status', OrderStatus::Pending)
            ->with(['restaurant', 'user', 'items.meal'])
            ->get();

        return $this->successResponse($orders, 'Available orders retrieved successfully');
    }

    /**
     * Get orders assigned to the authenticated driver
     */
    public function assignedOrders()
    {
        // Check if user is a driver
        if (Auth::user()->role !== UserRole::Driver->value) {
            return $this->errorResponse('Unauthorized. Driver access required.', 403);
        }

        $driverId = Auth::id();

        // Get orders assigned to this driver
        $orders = Order::where('driver_id', $driverId)
            ->with(['restaurant', 'user', 'items.meal'])
            ->get();

        return $this->successResponse($orders, 'Assigned orders retrieved successfully');
    }

    /**
     * Assign an order to the authenticated driver
     */
    public function assignOrder(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        // Check if user is a driver
        if (Auth::user()->role !== UserRole::Driver->value) {
            return $this->errorResponse('Unauthorized. Driver access required.', 403);
        }

        $driverId = Auth::id();

        // Find the order
        $order = Order::findOrFail($validated['order_id']);

        // Check if order is already assigned
        if ($order->driver_id !== null) {
            return $this->errorResponse('Order is already assigned to a driver', 400);
        }

        // Check if order status is appropriate for assignment
        if ($order->status !== OrderStatus::Pending) {
            return $this->errorResponse('Order cannot be assigned in its current status', 400);
        }

        // Assign the order to the driver and update status
        $order->driver_id = $driverId;
        $order->status = OrderStatus::OnTheWay;
        $order->save();

        return $this->successResponse($order->load(['restaurant', 'user', 'items.meal']), 'Order assigned successfully');
    }

    /**
     * Update order status (for driver to mark as delivered)
     */
    public function updateOrderStatus(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:delivered',
        ]);

        // Check if user is a driver
        if (Auth::user()->role !== UserRole::Driver->value) {
            return $this->errorResponse('Unauthorized. Driver access required.', 403);
        }

        $driverId = Auth::id();

        // Find the order
        $order = Order::findOrFail($validated['order_id']);

        // Check if order is assigned to this driver
        if ($order->driver_id !== $driverId) {
            return $this->errorResponse('Order is not assigned to you', 403);
        }

        // Update the status
        $order->status = OrderStatus::Delivered;
        $order->save();

        return $this->successResponse($order->load(['restaurant', 'user', 'items.meal']), 'Order status updated successfully');
    }

    /**
     * Show a specific order for the driver
     */
    public function showOrder($id)
    {
        // Check if user is a driver
        if (Auth::user()->role !== UserRole::Driver->value) {
            return $this->errorResponse('Unauthorized. Driver access required.', 403);
        }

        $driverId = Auth::id();

        // Find the order
        $order = Order::findOrFail($id);

        // Check if order is assigned to this driver or is available for pickup
        if ($order->driver_id !== $driverId && !($order->driver_id === null && $order->status === OrderStatus::Pending)) {
            return $this->errorResponse('You do not have access to this order', 403);
        }

        // Load relationships
        $order->load(['restaurant', 'user', 'items.meal']);

        return $this->successResponse($order, 'Order details retrieved successfully');
    }
}
