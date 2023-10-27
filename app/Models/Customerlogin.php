<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customerlogin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Notifiable;

    protected $guarded = ['id'];

    protected $guard = 'customerlogin';

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
