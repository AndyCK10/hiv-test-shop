@extends('layouts.appTemplate')

@section('css')
    
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    
    <div class="container">
        {{-- <div class="header">
            <h1>🧪 HIV Self Test Shop</h1>
            <p>ชุดตรวจ HIV ด้วยตนเอง ส่งถึงบ้าน ปลอดภัย เชื่อถือได้</p>
        </div>

        <div class="shipping">
            <strong>📦 ค่าจัดส่ง:</strong> 50 บาท (ทั้งแบบฟรีและแบบจ่ายเงิน)
        </div> --}}

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
                    <a href="{{ route('questionnaire.show', ['product_id' => $product->id]) }}" class="btn btn-secondary">
                        รับฟรี
                    </a>
                @endif
                
                <form method="POST" action="{{ route('cart.add') }}" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">
                        ซื้อสินค้า
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    
@endsection

@section('script')
    {{-- <script>
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
    </script> --}}
@endsection