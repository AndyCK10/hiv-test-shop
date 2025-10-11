<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'reset_token',
        'reset_token_expires'
    ];

    protected $hidden = [
        'password',
        'reset_token'
    ];

    protected $casts = [
        'reset_token_expires' => 'datetime'
    ];
}
