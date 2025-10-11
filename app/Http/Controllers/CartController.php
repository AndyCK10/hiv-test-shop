<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\QuestionnaireSession;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use Carbon\Carbon;

class CartController extends Controller
{
    const SHIPPING_COST = 50;
    private function getCart()
    {
        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'is_free' => 'sometimes|boolean'
        ]);

        $cart = $this->getCart();
        $product = Product::findOrFail($request->product_id);
        $isFree = $request->boolean('is_free') && $product->is_free_available;

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
        
        $shipping = $cartItems->count() > 0 ? self::SHIPPING_COST : 0;
        $total = $subtotal + $shipping;
        $cartCount = $cartItems->sum('quantity');

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total', 'cartCount'));
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'change' => 'required|integer|min:-100|max:100'
        ]);

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

        // Get saved questionnaire data for free items
        $sessionId = Session::getId();
        $questionnaireSession = QuestionnaireSession::where('session_id', $sessionId)
            ->where('expires_at', '>', Carbon::now())
            ->first();
            
        $product = null;
        if ($questionnaireSession) {
            $product = Product::find($questionnaireSession->product_id);
        }

        $subtotal = $cartItems->sum(function($item) use ($questionnaireSession, $product) {
            if ($questionnaireSession && $product && $questionnaireSession->product_id == $item->product->id && $item->is_free) {
                return 0;
            }
            return $item->product->price * $item->quantity;
        });

        // $subtotal = $cartItems->sum(function($item) {
        //     return $item->is_free ? 0 : ($item->product->price * $item->quantity);
        // });
        
        $shipping = self::SHIPPING_COST;
        $total = $subtotal + $shipping;
        $hasFreeItems = $cartItems->where('is_free', true)->count() > 0;

        $cartCount = $cartItems->sum('quantity');

        return view('checkout', compact('cartItems', 'cartCount', 'subtotal', 'shipping', 'total', 'hasFreeItems'));
    }

    public function processCheckout(Request $request)
    {
        $cart = $this->getCart();
        $cartItems = CartItem::where('cart_id', $cart->id)->with('product')->get();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'id_card' => 'sometimes|string|size:13'
        ]);

        $hasFreeItems = $cartItems->where('is_free', true)->count() > 0;

        // Get saved questionnaire data for free items (single query)
        $sessionId = Session::getId();
        $questionnaireSession = QuestionnaireSession::where('session_id', $sessionId)
            ->where('expires_at', '>', Carbon::now())
            ->first();
            
        $product = null;
        if ($questionnaireSession) {
            $product = Product::find($questionnaireSession->product_id);
        }

        $subtotal = $cartItems->sum(function($item) use ($questionnaireSession, $product) {
            if ($questionnaireSession && $product && $questionnaireSession->product_id == $item->product->id && $item->is_free) {
                return 0;
            }
            return $item->product->price * $item->quantity;
        });
        $total = $subtotal + self::SHIPPING_COST;

        // Create single order with multiple items
        $orderData = [
            'name' => ($hasFreeItems && $questionnaireSession) ? htmlspecialchars($questionnaireSession->name) : htmlspecialchars($request->name),
            'phone' => ($hasFreeItems && $questionnaireSession) ? htmlspecialchars($questionnaireSession->phone) : htmlspecialchars($request->phone),
            'email' => htmlspecialchars($request->email),
            'address' => htmlspecialchars($request->address),
            'is_free' => $hasFreeItems && $subtotal == 0,
            'total_amount' => $total,
            'status' => ($hasFreeItems && $subtotal == 0) ? 'confirmed' : 'pending'
        ];
        
        if ($hasFreeItems && $questionnaireSession) {
            $orderData['id_card'] = htmlspecialchars($questionnaireSession->id_card);
        } elseif ($request->id_card) {
            $orderData['id_card'] = htmlspecialchars($request->id_card);
        }
        
        $order = Order::create($orderData);

        // Create order items
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'is_free' => $item->is_free
            ]);
        }

        // Create questionnaire for free items
        if ($hasFreeItems && $questionnaireSession) {
            \App\Models\Questionnaire::create([
                'order_id' => $order->id,
                'name' => htmlspecialchars($questionnaireSession->name),
                'id_card' => htmlspecialchars($questionnaireSession->id_card),
                'phone' => htmlspecialchars($questionnaireSession->phone),
                'product_id' => $questionnaireSession->product_id,
                'answers' => $questionnaireSession->answers
            ]);
        }

        // Send emails
        $this->sendOrderEmails($order);

        // Clear cart
        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('payment', $order);
    }

    private function sendOrderEmails(Order $order)
    {
        try {
            // Send confirmation email to customer
            if ($order->email) {
                Mail::to($order->email)->send(new OrderConfirmation($order));
            }

            // Send notification to admin
            $adminEmail = env('ADMIN_EMAIL', 'admin@hivtestshop.com');
            Mail::to($adminEmail)->send(new AdminOrderNotification($order));
        } catch (\Exception $e) {
            // Log error but don't break the flow
            \Log::error('Failed to send order emails: ' . $e->getMessage());
        }
    }
}
