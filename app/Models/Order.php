<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'product_id',
        'name',
        'id_card',
        'phone',
        'email',
        'address',
        'is_free',
        'total_amount',
        'status',
        'payment_method',
        'payment_slip'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'is_free' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_no)) {
                $order->order_no = static::generateOrderNumber();
            }
        });
    }

    /**
     * Generate unique order number with database lock
     */
    private static function generateOrderNumber()
    {
        return \DB::transaction(function () {
            $today = today();
            $count = static::whereDate('created_at', $today)
                ->lockForUpdate()
                ->count();
            
            return 'ORD' . $today->format('Ymd') . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
