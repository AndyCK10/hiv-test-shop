@extends('layouts.authTemplate')

@section('css')
    <title>จัดการข้อมูลแอดมิน</title>
    <meta charset="UTF-8">
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #3498db; text-decoration: none; margin-right: 15px; } */
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        /* .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus { border-color: #3498db; outline: none; } */
        /* .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-secondary { background: #6c757d; color: white; } */
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'โปรไฟล์'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> > โปรไฟล์
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <div class="form-container">
            <h3>ข้อมูลแอดมิน</h3>
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="{{ $admin->username }}" readonly style="background: #f8f9fa;">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ $admin->email }}" readonly style="background: #f8f9fa;">
            </div>
            <div class="form-group">
                <label>วันที่สร้าง</label>
                <input type="text" value="{{ $admin->created_at->format('d/m/Y H:i') }}" readonly style="background: #f8f9fa;">
            </div>
        </div>

        <div class="form-container">
            <h3>เปลี่ยนรหัสผ่าน</h3>
            <form method="POST" action="{{ route('admin.change-password') }}">
                @csrf
                <div class="form-group">
                    <label>รหัสผ่านปัจจุบัน *</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label>รหัสผ่านใหม่ *</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label>ยืนยันรหัสผ่านใหม่ *</label>
                    <input type="password" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-success">เปลี่ยนรหัสผ่าน</button>
            </form>
        </div>

    </div>

@endsection

@section('script')

@endsection
