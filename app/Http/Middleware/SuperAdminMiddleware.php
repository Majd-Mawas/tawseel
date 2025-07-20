<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== UserRole::SuperAdmin->value) {
            if (Auth::check() && Auth::user()->role === UserRole::RestaurantAdmin->value) {
                return redirect()->route('dashboard.restaurant');
            }
            return redirect()->route('login')->with('error', 'Super admin access required.');
        }


        return $next($request);
    }
}
