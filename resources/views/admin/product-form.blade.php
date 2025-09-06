@extends('layouts.authTemplate')

@section('css')
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; } */
        /* .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; } */
        /* .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-secondary { background: #6c757d; color: white; } */
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .current-image { max-width: 200px; border-radius: 8px; margin: 10px 0; }
        #editor { border: 2px solid #ddd; border-radius: 8px; }
        @media (max-width: 768px) {
            /* .container { padding: 10px; }
            .form-container { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; } */
            #editor { height: 200px; }
        }
        @media (max-width: 480px) {
            /* .header h1 { font-size: 24px; }
            input, textarea, select { font-size: 16px; }
            .current-image { max-width: 150px; } */
        }
    </style>
@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' => isset($product) ? '✏️ แก้ไขสินค้า' : '➕ เพิ่มสินค้า'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> >
            <a href="{{ route('admin.products.index') }}">จัดการสินค้า</a> > {{ isset($product) ? 'แก้ไขสินค้า' : 'เพิ่มสินค้า' }}
        </div>

        <div class="form-container">
            <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>ชื่อสินค้า *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>คำอธิบายสั้น</label>
                    <textarea name="short_description" rows="2" placeholder="คำอธิบายสั้นๆ เพื่อแสดงในหน้ารายการสินค้า">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>ราคา (บาท) *</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>รายละเอียด</label>
                    <div id="editor" style="height: 300px;">{{ old('description', $product->description ?? '') }}</div>
                    <input type="hidden" name="description" id="description">
                </div>

                <div class="form-group">
                    <label>รูปภาพหลัก</label>
                    @if(isset($product) && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="current-image" alt="Current image">
                        <br><small>รูปภาพปัจจุบัน</small><br>
                    @endif
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="form-group">
                    <label>รูปภาพเพิ่มเติม (หลายรูป)</label>
                    @if(isset($product) && $product->images)
                        <div style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            @foreach($product->images as $img)
                                <img src="{{ asset('storage/' . $img) }}" style="max-width: 150px; border-radius: 5px;">
                            @endforeach
                        </div>
                        <small>รูปภาพเพิ่มเติมปัจจุบัน</small><br>
                    @endif
                    <input type="file" name="images[]" accept="image/*" multiple>
                    <small>สามารถเลือกหลายรูปพร้อมกันได้</small>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="is_free_available" value="1" {{ old('is_free_available', $product->is_free_available ?? false) ? 'checked' : '' }}>
                        <label>มีแบบฟรี (ต้องตอบแบบสอบถาม)</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <label>เปิดใช้งาน</label>
                    </div>
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($product) ? '💾 บันทึกการแก้ไข' : '➕ เพิ่มสินค้า' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Update hidden input when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('description').value = quill.root.innerHTML;
        });
    </script>
@endsection
