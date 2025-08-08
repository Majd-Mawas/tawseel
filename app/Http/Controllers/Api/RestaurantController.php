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
        return Restaurant::withCount('meals')
            ->orderBy('meals_count', 'asc')
            ->with('media')
            ->get();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return $restaurant->load([
            'meals' => function($query) {
                $query->limit(60);
            },
            'meals.media',
            'meals.category'
        ]);
    }
}
