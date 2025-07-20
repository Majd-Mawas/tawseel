<?php

namespace App\Http\Requests;

class UpdateRestaurantRequest extends BaseRequest
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
            'admin_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|unique:users,email,' . $this->route('restaurant')->admin->id,
            'admin_phone' => 'nullable|string|max:20',
            'admin_password' => 'nullable|string|min:8',
        ];
    }
}
