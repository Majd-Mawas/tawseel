<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
