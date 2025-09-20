<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Carbon\Carbon;

class ProductController extends Controller
{
    private function getCartCount()
    {
        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        return $cart ? CartItem::where('cart_id', $cart->id)->sum('quantity') : 0;
    }

    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $cartCount = $this->getCartCount();

        return view('index', compact('products', 'cartCount'));
    }

    public function detail($id)
    {
        // Validate ID parameter
        if (!is_numeric($id) || $id <= 0) {
            abort(404);
        }

        $product = Product::where('is_active', true)
            ->where('id', $id)
            ->firstOrFail();
        
        $cartCount = $this->getCartCount();

        return view('product-detail', compact('product', 'cartCount'));
    }
}
