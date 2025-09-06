<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
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
