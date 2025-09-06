<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'short_description',
        'price',
        'description',
        'image',
        'images',
        'is_free_available',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_free_available' => 'boolean',
        'is_active' => 'boolean',
        'images' => 'array'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
