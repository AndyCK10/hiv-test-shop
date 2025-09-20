{{-- <!DOCTYPE html>
<html>
<head>
    <title>ขอบคุณ</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .success-container { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); text-align: center; max-width: 500px; margin: 20px; }
        .success-icon { font-size: 80px; margin-bottom: 20px; }
        .success-title { font-size: 32px; color: #27ae60; margin-bottom: 15px; font-weight: bold; }
        .order-details { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: left; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .amount { font-size: 24px; font-weight: bold; color: #ff0000; }
        .btn { padding: 15px 30px; border: none; border-radius: 10px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 10px; font-weight: bold; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .note { background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 20px 0; font-size: 14px; }
        @media (max-width: 768px) {
            .success-container { padding: 30px 20px; margin: 10px; }
            .success-title { font-size: 24px; }
            .success-icon { font-size: 60px; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .success-container { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); text-align: center; max-width: 500px; margin: 20px; }
        .success-icon { font-size: 80px; margin-bottom: 20px; }
        .success-title { font-size: 32px; color: #27ae60; margin-bottom: 15px; font-weight: bold; }
        .order-details { background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: left; }
        .detail-row { display: flex; justify-content: space-between; margin: 10px 0; }
        .amount { font-size: 24px; font-weight: bold; color: #ff0000; }
        /* .btn { padding: 15px 30px; border: none; border-radius: 10px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 10px; font-weight: bold; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; } */
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .note { background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 20px 0; font-size: 14px; }
        @media (max-width: 768px) {
            .success-container { padding: 30px 20px; margin: 10px; }
            .success-title { font-size: 24px; }
            .success-icon { font-size: 60px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    <div class="success-container">
        <div class="success-icon">🎉</div>
        <h1 class="success-title">ขอบคุณสำหรับการสั่งซื้อ!</h1>
        <p>คำสั่งซื้อของคุณได้รับการยืนยันแล้ว</p>

        <div class="order-details">
            <h3>รายละเอียดคำสั่งซื้อ</h3>
            <div class="detail-row">
                <span>เลขที่คำสั่งซื้อ:</span>
                <strong>#{{ $order->order_no }}</strong>
            </div>
            <div class="detail-row">
                <span>สินค้า:</span>
                <span>{{ $order->product->name }}</span>
            </div>
            <div class="detail-row">
                <span>ลูกค้า:</span>
                <span>{{ $order->name }}</span>
            </div>
            <div class="detail-row">
                <span>เบอร์โทร:</span>
                <span>{{ $order->phone }}</span>
            </div>
            <div class="detail-row">
                <span>ที่อยู่จัดส่ง:</span>
                <span>{{ $order->address }}</span>
            </div>
            <div class="detail-row">
                <span>ยอดรวม:</span>
                <span class="amount">฿{{ number_format($order->total_amount) }}</span>
            </div>
            <div class="detail-row">
                <span>สถานะ:</span>
                <span style="color: #27ae60; font-weight: bold;">
                    @if($order->is_free)
                        ยืนยันแล้ว (ฟรี)
                    @else
                        รอการยืนยัน
                    @endif
                </span>
            </div>
        </div>

        <div class="note">
            <strong>📦 การจัดส่ง:</strong><br>
            @if($order->is_free)
                สินค้าฟรีจะได้รับการยืนยันและจัดส่งภายใน 1-2 วันทำการ
            @else
                เจ้าหน้าที่จะติดต่อยืนยันการชำระเงินและจัดส่งสินค้าภายใน 1-2 วันทำการ
            @endif
        </div>

        <div>
            {{-- <a href="{{ route('home') }}" class="btn btn-primary">🏠 กลับหน้าแรก</a> --}}
            <a href="{{ route('home') }}" class="btn btn-primary">สั่งซื้อเพิ่ม</a>
        </div>

        <div style="margin-top: 30px; color: #666; font-size: 14px;">
            <p>หากมีคำถาม กรุณาติดต่อเจ้าหน้าที่</p>
            <p>อ้างอิงเลขที่คำสั่งซื้อ: <strong>#{{ $order->order_no }}</strong></p>
        </div>
    </div>


@endsection

@section('script')

@endsection
