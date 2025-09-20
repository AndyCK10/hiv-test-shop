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
        'reset_token',
        'reset_token_expires'
    ];

    protected $hidden = [
        'password',
        'reset_token'
    ];

    protected $casts = [
        'password' => 'hashed',
        'reset_token_expires' => 'datetime'
    ];

    /**
     * Set the password attribute with proper hashing
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
