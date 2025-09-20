{{-- <!DOCTYPE html>
<html>
<head>
    <title>สั่งซื้อ - {{ $product->name }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus { border-color: #3498db; outline: none; }
        .btn { padding: 15px 30px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; width: 100%; }
        .btn:hover { background: #2980b9; }
        .product-info { background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .total { font-size: 24px; font-weight: bold; color: #ff0000; text-align: center; margin: 20px 0; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus { border-color: #3498db; outline: none; }
        .btn { padding: 15px 30px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; width: 100%; }
        .btn:hover { background: #2980b9; }
        .product-info { background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .total { font-size: 24px; font-weight: bold; color: #ff0000; text-align: center; margin: 20px 0; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    <div class="container">
        <div class="form-container">
            <div class="product-info">
                <h2>💳 สั่งซื้อ: {{ $product->name }}</h2>
                <p><strong>ราคาสินค้า:</strong> ฿{{ number_format($product->price) }}</p>
                <p><strong>ค่าจัดส่ง:</strong> ฿50</p>
                <div class="total">รวมทั้งสิ้น: ฿{{ number_format($product->price + 50) }}</div>
            </div>

            <form method="POST" action="{{ route('order.store-paid') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

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
                    <textarea name="address" rows="3" required></textarea>
                </div>

                <button type="submit" class="btn">📱 ดำเนินการชำระเงิน ฿{{ number_format($product->price + 50) }}</button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}">← กลับหน้าแรก</a>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
