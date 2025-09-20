<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionnaireSession;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class QuestionnaireSessionController extends Controller
{
    private function getCartCount()
    {
        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        return $cart ? CartItem::where('cart_id', $cart->id)->sum('quantity') : 0;
    }

    public function show(Request $request)
    {
        $request->validate([
            'product_id' => 'sometimes|exists:products,id'
        ]);

        $productId = $request->get('product_id');
        $cartCount = $this->getCartCount();

        return view('questionnaire', compact('cartCount', 'productId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'required|string|size:13',
            'phone' => 'required|string|max:20',
            'product_id' => 'sometimes|exists:products,id',
            'q1' => 'required|string',
            'q2' => 'required|string',
            'q3' => 'required|string',
            'q4' => 'required|string',
            'q5' => 'required|string',
            'q6' => 'required',
            'q7' => 'required|string',
            'q8' => 'required|string',
            'q9' => 'required|string',
            'q10' => 'required|string',
            'q11' => 'required|string',
            'q12' => 'required|string',
            'q13' => 'required|string',
        ]);

        $sessionId = Session::getId();
        $productId = $request->product_id ?? 1;

        // Sanitize inputs
        $sanitizedData = [
            'name' => htmlspecialchars($request->name),
            'id_card' => htmlspecialchars($request->id_card),
            'phone' => htmlspecialchars($request->phone),
            'product_id' => $productId,
            'answers' => [
                'q1' => htmlspecialchars($request->q1),
                'q2' => htmlspecialchars($request->q2),
                'q3' => htmlspecialchars($request->q3),
                'q4' => htmlspecialchars($request->q4),
                'q5' => htmlspecialchars($request->q5),
                'q6' => is_array($request->q6) ? implode(', ', array_map('htmlspecialchars', $request->q6)) : htmlspecialchars($request->q6),
                'q7' => htmlspecialchars($request->q7),
                'q8' => htmlspecialchars($request->q8),
                'q9' => htmlspecialchars($request->q9),
                'q10' => htmlspecialchars($request->q10),
                'q11' => htmlspecialchars($request->q11),
                'q12' => htmlspecialchars($request->q12),
                'q13' => htmlspecialchars($request->q13),
            ],
            'expires_at' => Carbon::now()->addHours(24)
        ];

        QuestionnaireSession::updateOrCreate(
            ['session_id' => $sessionId],
            $sanitizedData
        );

        Session::put('questionnaire_completed', true);

        // Handle product and cart logic
        if ($productId) {
            $product = Product::find($productId);
            if ($product && $product->is_free_available) {
                $cart = Cart::firstOrCreate(['session_id' => $sessionId]);
                CartItem::create([
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
