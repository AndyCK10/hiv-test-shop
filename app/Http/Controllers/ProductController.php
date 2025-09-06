<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        
        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }
        
        // return view('welcome', compact('products', 'cartCount'));
        return view('index', compact('products', 'cartCount'));
    }

    public function detail($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);
        
        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }
        
        return view('product-detail', compact('product', 'cartCount'));
    }
}
