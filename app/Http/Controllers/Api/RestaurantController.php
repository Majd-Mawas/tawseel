<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Restaurant::all()->load('media');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return $restaurant->load('meals', 'meals.media', 'meals.category');
    }
}
