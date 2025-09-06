<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Questionnaire;

class OrderController extends Controller
{
    public function showFreeForm(Product $product)
    {
        return view('order-free', compact('product'));
    }

    public function showPaidForm(Product $product)
    {
        return view('order-paid', compact('product'));
    }

    public function storeFree(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'id_card' => 'required|string|size:13',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
            'q4' => 'required',
            'q5' => 'required',
        ]);

        $order = Order::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'id_card' => $request->id_card,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_free' => true,
            'total_amount' => 50, // เฉพาะค่าส่ง
            'status' => 'confirmed'
        ]);

        Questionnaire::create([
            'order_id' => $order->id,
            'answers' => [
                'q1' => $request->q1,
                'q2' => $request->q2,
                'q3' => $request->q3,
                'q4' => $request->q4,
                'q5' => $request->q5,
            ]
        ]);

        return redirect()->route('payment', $order);
    }

    public function storePaid(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $product = Product::find($request->product_id);
        
        $order = Order::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_free' => false,
            'total_amount' => $product->price + 50, // ราคาสินค้า + ค่าส่ง
            'status' => 'pending'
        ]);

        return redirect()->route('payment', $order);
    }

    public function showPayment(Order $order)
    {
        $order->load('product');

        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }

        return view('payment', compact('order', 'cartCount'));
    }

    public function paymentSuccess(Order $order)
    {
        // Update order status to confirmed for paid orders
        if (!$order->is_free && $order->status === 'pending') {
            $order->update(['status' => 'confirmed']);
        }

        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }
        
        $order->load('product');
        return view('payment-success', compact('order', 'cartCount'));
    }
}
