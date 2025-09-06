{{-- <!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }} - HIV Self Test Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar { background: #2c3e50; padding: 15px 0; margin-bottom: 20px; }
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
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .product-detail { background: white; border-radius: 10px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px; }
        .product-images { }
        .main-image { width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 15px; }
        .no-image { width: 100%; height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: #666; font-size: 18px; }
        .additional-images { display: flex; gap: 10px; flex-wrap: wrap; }
        .additional-images img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; cursor: pointer; border: 2px solid transparent; }
        .additional-images img:hover { border-color: #3498db; }
        .product-info h1 { color: #2c3e50; margin-bottom: 15px; font-size: 32px; }
        .short-desc { color: #666; font-style: italic; margin-bottom: 20px; font-size: 18px; }
        .price { font-size: 36px; color: #e74c3c; font-weight: bold; margin: 20px 0; }
        .free-badge { background: #27ae60; color: white; padding: 8px 20px; border-radius: 20px; font-size: 16px; margin-left: 15px; }
        .description { color: #333; margin: 30px 0; line-height: 1.8; font-size: 16px; }
        .btn { padding: 15px 30px; margin: 10px 5px; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .actions { margin: 30px 0; }
        .back-link { margin-top: 30px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #2c3e50; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .product-grid { grid-template-columns: 1fr; gap: 20px; }
            .container { padding: 10px; }
            .product-detail { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link { padding: 8px 15px; font-size: 14px; }
            .product-info h1 { font-size: 24px; }
            .price { font-size: 28px; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .product-detail { background: white; border-radius: 10px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .product-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px; }
        .product-images { }
        .main-image { width: 100%; height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 15px; }
        .no-image { width: 100%; height: 400px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: #666; font-size: 18px; }
        .additional-images { display: flex; gap: 10px; flex-wrap: wrap; }
        .additional-images img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; cursor: pointer; border: 2px solid transparent; }
        .additional-images img:hover { border-color: #3498db; }
        .product-info h1 { color: #2c3e50; margin-bottom: 15px; font-size: 32px; }
        /* .short-desc { color: #666; font-style: italic; margin-bottom: 20px; font-size: 18px; } */
        /* .price { font-size: 24px; color: #e74c3c; font-weight: bold; margin: 0.25rem 0; } */
        /* .free-badge { background: #27ae60; color: white; padding: 8px 20px; border-radius: 20px; font-size: 16px; margin-left: 15px; } */
        .description { color: #333; margin: 30px 0; line-height: 1.8; font-size: 16px; }
        /* .btn { padding: 15px 30px; margin: 10px 5px; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-secondary { background: #6c757d; color: white; } */
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .actions { margin: 0.25rem 0; }
        .back-link { margin-top: 30px; }
        .back-link a { color: #3498db; text-decoration: none; }

        @media (max-width: 768px) {
            .product-grid { grid-template-columns: 1fr; gap: 20px; }
            .container { padding: 10px; }
            .product-detail { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; }
        }
        @media (max-width: 480px) {
            .product-info h1 { font-size: 24px; }
            .price { font-size: 28px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    
    <div class="container">
        <div class="product-detail">
            <div class="product-grid">
                <div class="product-images">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="main-image" alt="{{ $product->name }}" id="mainImage">
                    @else
                        <div class="no-image">ไม่มีรูปภาพ</div>
                    @endif
                    
                    @if($product->images && count($product->images) > 0)
                        <div class="additional-images">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" onclick="changeMainImage(this.src)" alt="Main">
                            @endif
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image) }}" onclick="changeMainImage(this.src)" alt="Additional">
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="product-info">
                    <h1>{{ $product->name }}</h1>
                    
                    @if($product->short_description)
                        <div class="short-desc">{{ $product->short_description }}</div>
                    @endif
                    
                    <div class="price">
                        ฿{{ number_format($product->price) }}
                        @if($product->is_free_available)
                            <span class="free-badge">มีแบบฟรี</span>
                        @endif
                    </div>
                    
                    <div class="actions">
                        @if($product->is_free_available)
                            <a href="{{ route('questionnaire.show', ['product_id' => $product->id]) }}" class="btn btn-secondary">
                                รับฟรี
                            </a>
                        @endif
                        
                        <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-primary">
                                ซื้อสินค้า (฿{{ number_format($product->price) }})
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            @if($product->description)
                <div class="description">
                    <h3>รายละเอียดสินค้า</h3>
                    <div>{!! $product->description !!}</div>
                </div>
            @endif
            
            {{-- <div class="back-link">
                <a href="{{ route('home') }}">← กลับหน้าหลัก</a>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
@endsection