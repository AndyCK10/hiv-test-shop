<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'order_no')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_no')->nullable()->after('id');
            });
        }
        
        // Update existing orders with order_no
        $orders = \App\Models\Order::whereNull('order_no')->get();
        foreach ($orders as $index => $order) {
            $order->update([
                'order_no' => 'ORD' . $order->created_at->format('Ymd') . str_pad($index + 1, 4, '0', STR_PAD_LEFT)
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_no');
        });
    }
};