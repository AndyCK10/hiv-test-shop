<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getCart()
    {
        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function add(Request $request)
    {
        $cart = $this->getCart();
        $product = Product::findOrFail($request->product_id);
        $isFree = $request->has('is_free') && $product->is_free_available;

        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('is_free', $isFree)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'is_free' => $isFree
            ]);
        }

        return redirect()->route('cart.show');
    }

    public function show()
    {
        $cart = $this->getCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->is_free ? 0 : ($item->product->price * $item->quantity);
        });
        
        $shipping = $cartItems->count() > 0 ? 50 : 0;
        $total = $subtotal + $shipping;
        $cartCount = $cartItems->sum('quantity');

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartCount'));
    }

    public function update(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $newQuantity = $item->quantity + $request->change;
        
        if ($newQuantity <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $newQuantity]);
        }

        return response()->json(['success' => true]);
    }

    public function remove($itemId)
    {
        CartItem::findOrFail($itemId)->delete();
        return response()->json(['success' => true]);
    }

    public function checkout()
    {
        $cart = $this->getCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->is_free ? 0 : ($item->product->price * $item->quantity);
        });
        
        $shipping = 50;
        $total = $subtotal + $shipping;
        $hasFreeItems = $cartItems->where('is_free', true)->count() > 0;

        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }

        return view('checkout', compact('cartItems', 'cartCount', 'subtotal', 'shipping', 'total', 'hasFreeItems'));
    }

    public function processCheckout(Request $request)
    {
        $cart = $this->getCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();
        
        $validation = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ];

        $hasFreeItems = $cartItems->where('is_free', true)->count() > 0;
        // Free items use data from questionnaire session

        $request->validate($validation);

        $subtotal = $cartItems->sum(function($item) {
            return $item->is_free ? 0 : ($item->product->price * $item->quantity);
        });
        
        $total = $subtotal + 50;

        // Get saved questionnaire data for free items
        $sessionId = Session::getId();
        $questionnaireSession = \App\Models\QuestionnaireSession::where('session_id', $sessionId)
            ->where('expires_at', '>', now())
            ->first();

        // Create orders for each product
        $orders = [];
        foreach ($cartItems as $item) {
            $orderData = [
                'product_id' => $item->product_id,
                'name' => $item->is_free && $questionnaireSession ? $questionnaireSession->name : $request->name,
                'phone' => $item->is_free && $questionnaireSession ? $questionnaireSession->phone : $request->phone,
                'address' => $request->address,
                'is_free' => $item->is_free,
                'total_amount' => $item->is_free ? 50 : ($item->product->price * $item->quantity) + 50,
                'status' => $item->is_free ? 'confirmed' : 'pending'
            ];
            
            if ($item->is_free && $questionnaireSession) {
                $orderData['id_card'] = $questionnaireSession->id_card;
            } elseif ($request->id_card) {
                $orderData['id_card'] = $request->id_card;
            }
            
            $order = Order::create($orderData);

            if ($hasFreeItems && $item->is_free) {
                // Get saved questionnaire answers
                $sessionId = Session::getId();
                $questionnaireSession = \App\Models\QuestionnaireSession::where('session_id', $sessionId)
                    ->where('expires_at', '>', now())
                    ->first();
                    
                if ($questionnaireSession) {
                    \App\Models\Questionnaire::create([
                        'order_id' => $order->id,
                        'answers' => $questionnaireSession->answers
                    ]);
                }
            }

            $orders[] = $order;
        }

        // Clear cart
        CartItem::where('cart_id', $cart->id)->delete();

        // Redirect to payment for the first paid order, or success page
        $paidOrder = collect($orders)->where('is_free', false)->first();
        if ($paidOrder) {
            return redirect()->route('payment', $paidOrder);
        }

        return redirect()->route('home')->with('success', 'สั่งซื้อเรียบร้อยแล้ว!');
    }
}
