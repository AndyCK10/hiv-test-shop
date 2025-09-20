@extends('layouts.authTemplate')

@section('css')
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #3498db; text-decoration: none; margin-right: 15px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #ff0000; color: white; }
        .logout { color: white; text-decoration: none; padding: 10px 20px; background: #ff0000; border-radius: 5px; } */
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .product-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .product-image { width: 100%; max-height: 270px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .no-image { width: 100%; height: 270px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 15px; color: #666; }
        .price { font-size: 24px; font-weight: bold; color: #ff0000; margin: 10px 0; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 12px; margin-left: 10px; }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'จัดการสินค้า'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> > จัดการสินค้า
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ค้นหาสินค้า</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ชื่อสินค้า หรือรายละเอียด" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">สถานะ</label>
                    <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">ทั้งหมด</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>เปิดใช้งาน</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>ปิดใช้งาน</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">แบบฟรี</label>
                    <select name="free" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">ทั้งหมด</option>
                        <option value="1" {{ request('free') == '1' ? 'selected' : '' }}>มีแบบฟรี</option>
                        <option value="0" {{ request('free') == '0' ? 'selected' : '' }}>ไม่มีแบบฟรี</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                    <a href="{{ route('admin.products.index') }}" class="btn" style="background: #6c757d; color: white;">ล้าง</a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ เพิ่มสินค้า</a>
                </div>
            </form>
        </div>

        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                @else
                    <div class="no-image">ไม่มีรูปภาพ</div>
                @endif

                <h3>{{ $product->name }}</h3>
                <div class="price">
                    ฿{{ number_format($product->price) }}
                    @if($product->is_free_available)
                        <span class="free-badge">มีแบบฟรี</span>
                    @endif
                </div>
                <p>{{ Str::limit($product->short_description, 100) }}</p>
                {{-- <p>{!! $product->description !!}</p> --}}

                <div style="margin-top: 15px;">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">แก้ไข</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('ต้องการลบสินค้านี้?')">ลบ</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection

@section('script')

@endsection
