{{-- <!DOCTYPE html>
<html>
<head>
    <title>ตะกร้าสินค้า</title>
    <meta charset="UTF-8">
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
        .header { text-align: center; margin-bottom: 30px; }
        .cart-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .cart-item { display: flex; align-items: center; padding: 20px; border-bottom: 1px solid #eee; }
        .cart-item:last-child { border-bottom: none; }
        .item-image { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
        .no-image { width: 80px; height: 80px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-right: 20px; font-size: 12px; color: #666; }
        .item-details { flex: 1; }
        .item-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .item-price { color: #ff0000; font-weight: bold; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin-left: 10px; }
        .quantity-controls { display: flex; align-items: center; gap: 10px; margin: 10px 0; }
        .qty-btn { width: 30px; height: 30px; border: 1px solid #ddd; background: white; cursor: pointer; border-radius: 5px; }
        .remove-btn { background: #ff0000; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; }
        .total-section { border-top: 2px solid #eee; padding-top: 20px; margin-top: 20px; text-align: right; }
        .total-price { font-size: 24px; font-weight: bold; color: #ff0000; margin: 10px 0; }
        .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .empty-cart { text-align: center; padding: 50px; color: #666; }
        @media (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #2c3e50; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .container { padding: 10px; }
            .cart-container { padding: 20px; }
            .cart-item { flex-direction: column; text-align: center; }
            .item-image, .no-image { margin: 0 auto 15px; }
            .quantity-controls { justify-content: center; }
            .btn { width: 100%; margin: 5px 0; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link { padding: 8px 15px; font-size: 14px; }
            .header h1 { font-size: 20px; }
            .item-name { font-size: 16px; }
            .total-price { font-size: 20px; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .cart-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .cart-item { display: flex; align-items: center; padding: 20px; border-bottom: 1px solid #eee; }
        .cart-item:last-child { border-bottom: none; }
        .item-image { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
        .no-image { width: 80px; height: 80px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-right: 20px; font-size: 12px; color: #666; }
        .item-details { flex: 1; }
        .item-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; color: #2c3e50;}
        .item-price { color: #ff0000; font-weight: bold; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin-left: 10px; }
        .quantity-controls { display: flex; align-items: center; gap: 10px; margin: 10px 0; }
        .qty-btn { width: 30px; height: 30px; border: 1px solid #ddd; background: white; cursor: pointer; border-radius: 5px; }
        .qty-btn.disabled { border: 1px solid #ccc; background: white; cursor:unset; }
        .remove-btn { background: #ff0000; color: white; border: none; padding: 5px 10px; border-radius: 10px; cursor: pointer; }
        .disabled-btn { background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 10px; }
        .total-section { /*border-top: 2px solid #eee;*/ padding-top: 20px; margin-top: 20px; text-align: right; }
        .total-price { font-size: 24px; font-weight: bold; color: #ff0000; margin: 10px 0; }
        .empty-cart { text-align: center; padding: 50px; color: #666; }
        .mt-2{margin-top: 1rem;}
        @media (max-width: 768px) {
            .cart-container { padding: 20px; }
            .cart-item { flex-direction: column; text-align: center; }
            .item-image, .no-image { margin: 0 auto 15px; }
            .quantity-controls { justify-content: center; }
            .btn { width: 100%; margin: 5px 0; }
            .mt-2{margin-top: 1rem;}
        }
        @media (max-width: 480px) {
            .header h1 { font-size: 20px; }
            .item-name { font-size: 16px; }
            .total-price { font-size: 20px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])

    <div class="container">
        <div class="header">
            <h1>🛒 ตะกร้าสินค้า @if($cartCount > 0)({{ $cartCount }} ชิ้น)@endif</h1>
        </div>

        <div class="cart-container">
            @if($cartItems->count() > 0)
                @foreach($cartItems as $item)
                <div class="cart-item">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" class="item-image" alt="{{ $item->product->name }}">
                    @else
                        <div class="no-image">ไม่มีรูป</div>
                    @endif

                    <div class="item-details">
                        <div class="item-name">
                            <a href="{{ route('product.detail', $item->product->id) }}">{{ $item->product->name }}</a>
                            @if($item->is_free)
                                <span class="free-badge">ฟรี</span>
                            @endif
                        </div>
                        <div class="item-price">
                            @if($item->is_free)
                                ฟรี (ค่าส่ง ฿50)
                            @else
                                ฿{{ number_format($item->product->price) }}
                            @endif
                        </div>

                        <div class="quantity-controls">
                            <button @if($item->is_free) class="qty-btn disabled" @disabled(true) @else class="qty-btn" onclick="updateQuantity({{ $item->id }}, -1)" @endif>-</button>
                            <span>{{ $item->quantity }}</span>
                            <button @if($item->is_free) class="qty-btn disabled" @disabled(true) @else class="qty-btn" onclick="updateQuantity({{ $item->id }}, 1)" @endif>+</button>
                            <button @if($item->is_free) class="disabled-btn"  @disabled(true) @else class="remove-btn"  onclick="removeItem({{ $item->id }})" @endif>ลบ</button>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="total-section">
                    <div>ค่าสินค้า: ฿{{ number_format($subtotal) }}</div>
                    <div>ค่าจัดส่ง: ฿{{ number_format($shipping) }}</div>
                    <div class="total-price">รวมทั้งสิ้น: ฿{{ number_format($total) }}</div>

                    <div style="margin-top: 20px;">
                        <a href="{{ route('checkout') }}" class="btn btn-primary">สั่งซื้อ</a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">เลือกสินค้าต่อ</a>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <h3>ตะกร้าสินค้าว่าง</h3>
                    <p>ยังไม่มีสินค้าในตะกร้า</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-2">เลือกซื้อสินค้า</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateQuantity(itemId, change) {
            fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ change: change })
            }).then(() => location.reload());
        }

        function removeItem(itemId) {
            if (confirm('ต้องการลบสินค้านี้จากตะกร้า?')) {
                fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => location.reload());
            }
        }
    </script>

    <script>
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.getElementById('navMenu');

            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        }

        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.hamburger').classList.remove('active');
                document.getElementById('navMenu').classList.remove('active');
            });
        });
    </script>
@endsection

@section('script')

@endsection
