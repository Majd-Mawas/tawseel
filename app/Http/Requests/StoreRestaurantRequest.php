<?php

namespace App\Http\Requests;

class StoreRestaurantRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'type' => 'required|in:restaurant,shop_center',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_phone' => 'required|string|max:20',
            'admin_password' => 'required|string|min:8',
        ];
    }
}
