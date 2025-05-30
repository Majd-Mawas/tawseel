<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard index page.
     */
    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * Display the user's profile page.
     */
    public function profile(): View
    {
        return view('dashboard.profile');
    }

    /**
     * Display the user's orders page.
     */
    public function orders(): View
    {
        return view('dashboard.orders');
    }

    /**
     * Display the user's settings page.
     */
    public function settings(): View
    {
        return view('dashboard.settings');
    }
}
