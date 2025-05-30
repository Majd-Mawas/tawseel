<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Preparing = 'preparing';
    case OnTheWay = 'on_the_way';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}
