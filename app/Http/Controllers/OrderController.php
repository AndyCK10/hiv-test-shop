<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Questionnaire;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use Carbon\Carbon;

class OrderController extends Controller
{
    const SHIPPING_COST = 50;

    private function getCartCount()
    {
        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        return $cart ? CartItem::where('cart_id', $cart->id)->sum('quantity') : 0;
    }
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
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'q1' => 'required|string',
            'q2' => 'required|string',
            'q3' => 'required|string',
            'q4' => 'required|string',
            'q5' => 'required|string',
        ]);

        $order = DB::transaction(function () use ($request) {
            $order = Order::create([
                'product_id' => $request->product_id,
                'name' => htmlspecialchars($request->name),
                'id_card' => htmlspecialchars($request->id_card),
                'phone' => htmlspecialchars($request->phone),
                'email' => htmlspecialchars($request->email),
                'address' => htmlspecialchars($request->address),
                'is_free' => true,
                'total_amount' => self::SHIPPING_COST,
                // 'status' => 'confirmed'
                'status' => 'pending'
            ]);

            Questionnaire::create([
                'order_id' => $order->id,
                'answers' => [
                    'q1' => htmlspecialchars($request->q1),
                    'q2' => htmlspecialchars($request->q2),
                    'q3' => htmlspecialchars($request->q3),
                    'q4' => htmlspecialchars($request->q4),
                    'q5' => htmlspecialchars($request->q5),
                ]
            ]);

            return $order;
        });

        // Send emails for confirmed free order
        $this->sendOrderEmails($order);

        return redirect()->route('payment', $order);
    }

    public function storePaid(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'id_card' => 'sometimes|string|size:13',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $orderData = [
            'product_id' => $request->product_id,
            'name' => htmlspecialchars($request->name),
            'phone' => htmlspecialchars($request->phone),
            'email' => htmlspecialchars($request->email),
            'address' => htmlspecialchars($request->address),
            'is_free' => false,
            'total_amount' => $product->price + self::SHIPPING_COST,
            'status' => 'pending'
        ];

        if ($request->id_card) {
            $orderData['id_card'] = htmlspecialchars($request->id_card);
        }

        $order = Order::create($orderData);

        // Send emails for new paid order
        $this->sendOrderEmails($order);

        return redirect()->route('payment', $order);
    }

    public function showPayment(Order $order)
    {
        $order->load(['product', 'orderItems.product']);
        $cartCount = $this->getCartCount();

        $bank_qr_code = env('BANK_RECEIVER_QR_CODE', '0123456789');

        return view('payment', compact('order', 'cartCount', 'bank_qr_code'));
    }

    public function verifySlip(Request $request, Order $order)
    {
        $request->validate([
            'slip_image' => 'required|string' // base64 image
        ]);

        try {
            // Mock slip verification (replace with actual OCR/AI service)
            $verification = $this->performSlipVerification($request->slip_image, $order->total_amount);
            
            return response()->json($verification);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'เกิดข้อผิดพลาดในการตรวจสอบสลิป'
            ], 500);
        }
    }

    private function performSlipVerification($imageData, $expectedAmount)
    {
        // Mock verification logic (replace with actual OCR/AI service)
        // This would typically call an external API like Google Vision API, AWS Textract, etc.
        
        $random = rand(1, 10);
        
        if ($random <= 7) { // 70% success rate
            return [
                'success' => true,
                'amount' => $expectedAmount,
                'time' => Carbon::now()->format('d/m/Y H:i:s'),
                'bank' => 'ธนาคารกสิกรไทย',
                'reference' => 'REF' . rand(100000, 999999)
            ];
        } else {
            $errors = [
                'ยอดเงินไม่ตรงกับคำสั่งซื้อ',
                'ไม่สามารถอ่านข้อมูลในสลิปได้',
                'รูปภาพไม่ชัดเจน กรุณาถ่ายรูปใหม่'
            ];
            return [
                'success' => false,
                'error' => $errors[array_rand($errors)]
            ];
        }
    }

    public function uploadSlip(Request $request, Order $order)
    {
        $request->validate([
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $currentDate = Carbon::now()->format('Y-m-d');

        try {
            if ($request->hasFile('payment_slip')) {
                $slipPath = $request->file('payment_slip')->store('payment-slips/'.$currentDate, 'public');
                
                $order->update([
                    'payment_slip' => $slipPath,
                    // 'status' => 'confirmed' // todo รอยืนยันจาก admin
                ]);
                
                // Send emails when slip is uploaded and order is confirmed
                $this->sendOrderEmails($order);
            }

            return redirect()->route('payment.success', $order)
                ->with('success', 'อัพโหลดสลิปเรียบร้อยแล้ว กำลังตรวจสอบการชำระเงิน');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการอัพโหลดสลิป');
        }
    }

    public function paymentSuccess(Order $order)
    {
        // Update order status to confirmed for paid orders
        // todo
        // if (!$order->is_free && $order->status === 'pending') {
        //     $order->update(['status' => 'confirmed']);
        // }

        // Send emails
        $this->sendOrderEmails($order);

        $cartCount = $this->getCartCount();
        $order->load(['product', 'orderItems.product']);
        
        return view('payment-success', compact('order', 'cartCount'));
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
