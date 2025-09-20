{{-- <!DOCTYPE html>
<html>
<head>
    <title>เช็คเอาท์</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .navbar { background: #2c3e50; padding: 15px 0; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-menu { display: flex; gap: 30px; }
        .nav-menu a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .nav-menu a:hover { color: #3498db; }
        .hamburger { display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: white; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
        .cart-link { background: #3498db; color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; position: relative; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #ff0000; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .checkout-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus { border-color: #3498db; outline: none; }
        .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-success { background: #27ae60; color: white; width: 100%; }
        .btn-secondary { background: #6c757d; color: white; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .order-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-weight: bold; font-size: 18px; border-top: 2px solid #ddd; padding-top: 10px; }
        .free-notice { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 20px 0; }
        @media (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #2c3e50; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .container { padding: 10px; }
            .checkout-container { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; }
            .order-item { flex-direction: column; gap: 5px; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link { padding: 8px 15px; font-size: 14px; }
            .header h1 { font-size: 24px; }
            input, textarea { font-size: 16px; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .checkout-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus { border-color: #3498db; outline: none; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .order-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-weight: bold; font-size: 18px; border-top: 1px solid #ddd; padding-top: 10px; }
        .free-notice { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 20px 0; }
        @media (max-width: 768px) {
            .checkout-container { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; }
            .order-item { flex-direction: column; gap: 5px; }
        }
        @media (max-width: 480px) {
            .header h1 { font-size: 24px; }
            input, textarea { font-size: 16px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])

    <div class="container">
        <div class="checkout-container">
            <div class="header">
                <h1>🛒 เช็คเอาท์</h1>
                <p>กรอกข้อมูลสำหรับจัดส่งสินค้า</p>
            </div>

            <div class="order-summary">
                <h3>สรุปคำสั่งซื้อ</h3>
                @foreach($cartItems as $item)
                <div class="order-item">
                    <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                    <span>
                        @if($item->is_free)
                            ฟรี
                        @else
                            ฿{{ number_format($item->product->price * $item->quantity) }}
                        @endif
                    </span>
                </div>
                @endforeach
                <div class="order-item">
                    <span>ค่าจัดส่ง</span>
                    <span>฿{{ number_format($shipping) }}</span>
                </div>
                <div class="order-item total">
                    <span>รวมทั้งสิ้น</span>
                    <span>฿{{ number_format($total) }}</span>
                </div>
            </div>

            @if($hasFreeItems)
                <div class="free-notice">
                    ✓ แบบสอบถามและข้อมูลส่วนตัวเสร็จสิ้นแล้ว (สำหรับสินค้าฟรี)
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.process') }}">
                @csrf

                <div class="form-group">
                    <label>ชื่อ-สกุล *</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>เบอร์โทร *</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-group">
                    <label>อีเมล *</label>
                    <input type="email" name="email" required placeholder="example@email.com">
                </div>

                <div class="form-group">
                    <label>ที่อยู่จัดส่ง *</label>
                    <textarea name="address" rows="4" required placeholder="กรุณากรอกที่อยู่ให้ครบถ้วน เพื่อความถูกต้องในการจัดส่ง"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    ยืนยันคำสั่งซื้อ (฿{{ number_format($total) }})
                </button>
            </form>

            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('cart.show') }}" style="color: #3498db; text-decoration: none;">กลับไปแก้ไขตะกร้า</a>
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection
