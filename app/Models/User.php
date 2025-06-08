<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'verification_code_expires_at' => 'datetime',
    ];

    public function generateVerificationCode()
    {
        $this->verification_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->verification_code_expires_at = now()->addHours(3);
        $this->save();

        return $this->verification_code;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'user_id');
    }
}
