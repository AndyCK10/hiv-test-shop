<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireSession extends Model
{
    protected $fillable = [
        'session_id',
        'name',
        'id_card',
        'phone',
        'answers',
        'product_id',
        // 'order_id',
        'expires_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'expires_at' => 'datetime'
    ];

    // public function order()
    // {
    //     return $this->belongsTo(Order::class, 'order_id');
    // }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
