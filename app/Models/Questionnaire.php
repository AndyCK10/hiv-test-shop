<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $fillable = [
        'order_id',
        'name',
        'id_card',
        'phone',
        'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
