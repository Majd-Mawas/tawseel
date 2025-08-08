<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case SuperAdmin = 'super_admin';
    case RestaurantAdmin = 'restaurant_admin';
    case Driver = 'driver';
}
