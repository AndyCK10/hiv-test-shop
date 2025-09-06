<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'id_card',
        'phone',
        'address',
        'is_free',
        'total_amount',
        'status',
        'payment_method'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'is_free' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class);
    }
}
