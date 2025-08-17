<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutingController extends Controller
{

    public function __construct()
    {
        // $this->
        // middleware('auth')->
        // except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()) {
            if (Auth::user()->role == "restaurant_admin") {
                return redirect()->route('admin.restaurants.index');
            } elseif (Auth::user()->role == "super_admin") {
                return redirect()->route('dashboard.restaurant');
            }
        } else {
            return redirect('login');
        }
    }

    /**
     * Display a view based on first route param
     *
     * @return \Illuminate\Http\Response
     */
    public function root(Request $request, $first)
    {

        $mode = $request->query('mode');
        $demo = $request->query('demo');

        if ($first == "assets")
            return redirect('home');

        return view($first, ['mode' => $mode, 'demo' => $demo]);
    }

    /**
     * second level route
     */
    public function secondLevel(Request $request, $first, $second)
    {

        $mode = $request->query('mode');
        $demo = $request->query('demo');

        if ($first == "assets")
            return redirect('home');



        return view($first . '.' . $second, ['mode' => $mode, 'demo' => $demo]);
    }

    /**
     * third level route
     */
    public function thirdLevel(Request $request, $first, $second, $third)
    {
        $mode = $request->query('mode');
        $demo = $request->query('demo');

        if ($first == "assets")
            return redirect('home');

        dd($first, $second, $third);

        return view($first . '.' . $second . '.' . $third, ['mode' => $mode, 'demo' => $demo]);
    }
}
