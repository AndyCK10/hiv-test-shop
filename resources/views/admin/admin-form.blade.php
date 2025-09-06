@extends('layouts.authTemplate')

@section('css')
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; } */
        /* .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus { border-color: #3498db; outline: none; } */
        /* .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; } */
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  isset($admin) ? '✏️ แก้ไขแอดมิน' : '➕ เพิ่มแอดมิน'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> >
            <a href="{{ route('admin.admins.index') }}">จัดการแอดมิน</a> > {{ isset($admin) ? 'แก้ไขแอดมิน' : 'เพิ่มแอดมิน' }}
        </div>
        <div class="form-container">
            @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ isset($admin) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}">
                @csrf
                @if(isset($admin))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" value="{{ old('username', $admin->username ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>รหัสผ่าน {{ isset($admin) ? '(เว้นว่างหากไม่ต้องการเปลี่ยน)' : '*' }}</label>
                    <input type="password" name="password" {{ !isset($admin) ? 'required' : '' }}>
                </div>

                @if(isset($admin))
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input type="password" name="password_confirmation">
                </div>
                @endif

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($admin) ? '💾 บันทึกการแก้ไข' : '➕ เพิ่มแอดมิน' }}
                    </button>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')

@endsection
