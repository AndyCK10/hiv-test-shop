@extends('layouts.authTemplate')

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .current-image { max-width: 200px; border-radius: 8px; margin: 10px 0; }
        #editor { border: 1px solid #ddd; border-top: none; border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; min-height: 300px; }
        .editor-fallback { display: none; }
        .error-message { color: #dc3545; font-size: 14px; margin-top: 5px; }
        .loading-editor { padding: 20px; text-align: center; color: #6c757d; }

        .ql-toolbar.ql-snow {
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: 'Inter', 'Kanit', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            padding: 8px;
            border-top-right-radius: 8px;
            border-top-left-radius: 8px;
        }
        .ql-container {
            font-family: var(--var-font-family);
        }
        
        @media (max-width: 768px) {
            #editor { height: 200px; min-height: 200px; }
            .current-image { max-width: 150px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' => isset($product) ? 'แก้ไขสินค้า' : 'เพิ่มสินค้า'
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
                    <div id="editor-container">
                        <div id="editor" style="height: 300px;">
                            <div class="loading-editor">กำลังโหลดเครื่องมือแก้ไข...</div>
                        </div>
                        <textarea name="description" id="description" class="editor-fallback" rows="10" style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px;">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>
                    <div id="editor-error" class="error-message"></div>
                </div>

                <div class="form-group">
                    <label>รูปภาพหลัก</label>
                    @if(isset($product) && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="current-image" alt="Current image">
                        <br><small>รูปภาพปัจจุบัน</small><br>
                    @endif
                    <input type="file" name="image" accept="image/*" style="width: 250px;">
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
                    <input type="file" name="images[]" accept="image/*" multiple style="width: 250px;">
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
                        {{ isset($product) ? 'บันทึกการแก้ไข' : 'เพิ่มสินค้า' }}
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
        document.addEventListener('DOMContentLoaded', function() {
            let quill = null;
            let editorInitialized = false;
            
            // Initialize Quill editor with error handling
            try {
                if (typeof Quill !== 'undefined') {
                    const initialContent = {!! json_encode(old('description', $product->description ?? '')) !!};
                    
                    quill = new Quill('#editor', {
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
                    
                    // Set initial content
                    if (initialContent) {
                        quill.root.innerHTML = initialContent;
                    }
                    
                    editorInitialized = true;
                    document.getElementById('description').style.display = 'none';
                } else {
                    throw new Error('Quill library not loaded');
                }
            } catch (error) {
                console.error('Failed to initialize Quill editor:', error);
                showEditorFallback('ไม่สามารถโหลดเครื่องมือแก้ไขได้ กรุณาใช้ช่องข้อความธรรมดา');
            }
            
            // Form submission handler with error handling
            document.querySelector('form').addEventListener('submit', function(e) {
                try {
                    if (editorInitialized && quill) {
                        const content = quill.root.innerHTML;
                        document.getElementById('description').value = content;
                    }
                    // If editor failed, textarea value will be used automatically
                } catch (error) {
                    console.error('Error getting editor content:', error);
                    // Continue with form submission using textarea value
                }
            });
            
            function showEditorFallback(message) {
                document.getElementById('editor').style.display = 'none';
                document.getElementById('description').style.display = 'block';
                document.getElementById('description').classList.remove('editor-fallback');
                
                const errorDiv = document.getElementById('editor-error');
                if (errorDiv && message) {
                    errorDiv.textContent = message;
                }
            }
            
            // Fallback timeout
            setTimeout(function() {
                if (!editorInitialized) {
                    showEditorFallback('เครื่องมือแก้ไขโหลดช้า กรุณาใช้ช่องข้อความธรรมดา');
                }
            }, 5000);
        });
    </script>
@endsection
