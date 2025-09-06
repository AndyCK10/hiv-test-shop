<!DOCTYPE html>
<html>
<head>
    <title>HIV Self Test Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" /> --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Kanit', Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .navbar { background: #2c3e50; padding: 15px 0; margin-bottom: 20px; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-menu { display: flex; gap: 30px; }
        .nav-menu a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .nav-menu a:hover { color: #3498db; }
        .nav-menu a.active { color: #3498db; }
        .hamburger { display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: white; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
        .cart-link { background: #3498db; color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; position: relative; }
        .cart-link:hover { background: #2980b9; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .header { text-align: center; margin-bottom: 40px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .products { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .product { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .product-image { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .no-image { width: 100%; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 15px; color: #666; }
        .product h3 { color: #2c3e50; margin-bottom: 15px; font-size: 24px; }
        .product h3 a { color: #2c3e50; text-decoration: none; }
        .product h3 a:hover { color: #3498db; }
        .short-desc { color: #666; font-style: italic; margin-bottom: 10px; }
        .price { font-size: 28px; color: #e74c3c; font-weight: bold; margin: 15px 0; }
        .free-badge { background: #27ae60; color: white; padding: 5px 15px; border-radius: 20px; font-size: 14px; margin-left: 10px; }
        .btn { padding: 12px 25px; margin: 10px 5px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .description { color: #666; margin: 15px 0; line-height: 1.6; }
        .shipping { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin: 20px 0; }
        @media (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #2c3e50; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .container { padding: 10px; }
            .header { padding: 20px; }
            .products { grid-template-columns: 1fr; gap: 20px; }
            .product { padding: 20px; }
            .btn { width: 100%; margin: 5px 0; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link { padding: 8px 15px; font-size: 14px; }
            .header h1 { font-size: 24px; }
            .product h3 { font-size: 20px; }
            .price { font-size: 24px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="nav-menu" id="navMenu">
                <a href="{{ route('home') }}" class="active">🏠 หน้าหลัก</a>
                <a href="{{ route('home') }}">📦 สินค้า</a>
                <a href="{{ route('questionnaire.show') }}">📋 แบบสอบถาม</a>
            </div>
            <a href="{{ route('cart.show') }}" class="cart-link">
                🛒 ตะกร้า
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </nav>
    
    <div class="container">
        <div class="header">
            <h1>🧪 HIV Self Test Shop</h1>
            <p>ชุดตรวจ HIV ด้วยตนเอง ส่งถึงบ้าน ปลอดภัย เชื่อถือได้</p>
        </div>

        <div class="shipping">
            <strong>📦 ค่าจัดส่ง:</strong> 50 บาท (ทั้งแบบฟรีและแบบจ่ายเงิน)
        </div>

        <div class="products">
            @foreach($products as $product)
            <div class="product">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                @else
                    <div class="no-image">ไม่มีรูปภาพ</div>
                @endif
                <h3><a href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a></h3>
                @if($product->short_description)
                    <div class="short-desc">{{ $product->short_description }}</div>
                @endif
                <div class="price">
                    ฿{{ number_format($product->price) }}
                    @if($product->is_free_available)
                        <span class="free-badge">มีแบบฟรี</span>
                    @endif
                </div>
                
                @if($product->is_free_available)
                    <a href="{{ route('questionnaire.show', ['product_id' => $product->id]) }}" class="btn btn-success">
                        🆓 รับฟรี (ต้องตอบแบบสอบถาม)
                    </a>
                @endif
                
                <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">
                        🛒 ซื้อสินค้า (฿{{ number_format($product->price) }})
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.getElementById('navMenu');
            
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        }

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.hamburger').classList.remove('active');
                document.getElementById('navMenu').classList.remove('active');
            });
        });
    </script>
</body>
</html>