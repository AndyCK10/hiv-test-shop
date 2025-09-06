{{-- <!DOCTYPE html>
<html>
<head>
    <title>ชำระเงิน</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .payment-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .amount { font-size: 36px; font-weight: bold; color: #e74c3c; margin: 20px 0; }
        .bank-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 30px 0; }
        .bank-btn { padding: 15px; border: none; border-radius: 10px; cursor: pointer; font-size: 16px; font-weight: bold; color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .scb { background: #4e2a84; }
        .kbank { background: #138f2d; }
        .bbl { background: #1e4598; }
        .ktb { background: #1ba1e6; }
        .bay { background: #fec43b; color: #333; }
        .gsb { background: #eb6101; }
        .bank-btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .instructions { background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left; }
        .back-link { margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .payment-container { padding: 20px; }
            .bank-buttons { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .payment-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .amount { font-size: 36px; font-weight: bold; color: #e74c3c; margin: 20px 0; }
        .bank-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 30px 0; }
        .bank-btn { padding: 15px; border: none; border-radius: 25px; cursor: pointer; font-size: 16px; font-weight: bold; color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .scb { background: #4e2a84; }
        .kbank { background: #138f2d; }
        .bbl { background: #1e4598; }
        .ktb { background: #1ba1e6; }
        .bay { background: #fec43b; color: #333; }
        .gsb { background: #eb6101; }
        .bank-btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .instructions { background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left; }
        .back-link { margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .payment-container { padding: 20px; }
            .bank-buttons { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    <div class="container">
        <div class="payment-container">
            <h1>💳 ชำระเงิน</h1>
            
            <div class="order-summary">
                <h3>รายละเอียดคำสั่งซื้อ #{{ $order->id }}</h3>
                <p><strong>สินค้า:</strong> {{ $order->product->name }}</p>
                <p><strong>ลูกค้า:</strong> {{ $order->name }}</p>
                <div class="amount">฿{{ number_format($order->total_amount) }}</div>
            </div>

            <div class="instructions">
                <h4>📱 วิธีการชำระเงิน:</h4>
                <ol>
                    <li>เลือกธนาคารที่ต้องการ</li>
                    <li>แอปธนาคารจะเปิดขึ้นพร้อมยอดเงิน</li>
                    <li>กดยืนยันการชำระเงิน</li>
                    <li>กลับมาที่ระบบเพื่อดูผลการสั่งซื้อ</li>
                </ol>
            </div>

            <h3>เลือกธนาคาร</h3>
            <div class="bank-buttons">
                <a href="scbeasy://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn scb">
                    🏦 SCB Easy
                </a>
                <a href="kplus://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn kbank">
                    🏦 K PLUS
                </a>
                <a href="bualuang://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn bbl">
                    🏦 Bualuang
                </a>
                {{-- <a href="krungthai://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn ktb">
                    🏦 Krungthai
                </a>
                <a href="krungsribank://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn bay">
                    🏦 KMA
                </a>
                <a href="gsb://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn gsb">
                    🏦 GSB
                </a> --}}
            </div>

            {{-- <div style="margin: 30px 0; padding: 20px; background: #fff3cd; border-radius: 8px;">
                <p><strong>⚠️ หมายเหตุ:</strong></p>
                <p>หากไม่มีแอปธนาคาร สามารถโอนเงินผ่านช่องทางอื่นได้</p>
                <p>เลขที่อ้างอิง: <strong>#{{ $order->id }}</strong></p>
            </div> --}}

            <a href="{{ route('payment.success', $order->id) }}" class="btn btn-primary">
                ชำระเงินเรียบร้อยแล้ว
            </a>

            {{-- <div class="back-link">
                <a href="{{ route('home') }}">← กลับหน้าแรก</a>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Fallback for mobile apps that don't support deep linking
        document.querySelectorAll('.bank-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                setTimeout(() => {
                    if (confirm('หากแอปธนาคารไม่เปิด กดตกลงเพื่อไปหน้าขอบคุณ')) {
                        window.location.href = '{{ route("payment.success", $order->id) }}';
                    }
                }, 3000);
            });
        });
    </script>
@endsection