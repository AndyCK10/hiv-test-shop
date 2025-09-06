<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionnaireSession;
use Illuminate\Support\Facades\Session;

class QuestionnaireSessionController extends Controller
{
    public function show(Request $request)
    {
        $productId = $request->get('product_id');

        // Get cart count
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');
        }

        return view('questionnaire', compact('productId', 'cartCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'required|string|size:13',
            'phone' => 'required|string|max:20',
            'product_id' => 'nullable|exists:products,id',
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
            'q4' => 'required',
            'q5' => 'required',
            'q6' => 'required',
            'q7' => 'required',
            'q8' => 'required',
            'q9' => 'required',
            'q10' => 'required',
            'q11' => 'required',
            'q12' => 'required',
            'q13' => 'required',
        ]);

        $sessionId = Session::getId();
        
        QuestionnaireSession::updateOrCreate(
            ['session_id' => $sessionId],
            [
                'name' => $request->name,
                'id_card' => $request->id_card,
                'phone' => $request->phone,
                'answers' => [
                    'q1' => $request->q1,
                    'q2' => $request->q2,
                    'q3' => $request->q3,
                    'q4' => $request->q4,
                    'q5' => $request->q5,
                    'q6' => is_array($request->q6) ? implode(', ', $request->q6) : $request->q6,
                    'q7' => $request->q7,
                    'q8' => $request->q8,
                    'q9' => $request->q9,
                    'q10' => $request->q10,
                    'q11' => $request->q11,
                    'q12' => $request->q12,
                    'q13' => $request->q13,
                ],
                'expires_at' => now()->addHours(24)
            ]
        );

        Session::put('questionnaire_completed', true);
        
        // If product_id is provided, add to cart and redirect to checkout
        if ($request->product_id) {
            $product = \App\Models\Product::findOrFail($request->product_id);
            if ($product->is_free_available) {
                // Add free item to cart
                $cart = \App\Models\Cart::firstOrCreate(['session_id' => Session::getId()]);
                \App\Models\CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'is_free' => true
                ]);
                
                return redirect()->route('checkout');
            }
        }
        
        return redirect()->route('home')->with('success', 'บันทึกแบบสอบถามเรียบร้อยแล้ว!');
    }
}
