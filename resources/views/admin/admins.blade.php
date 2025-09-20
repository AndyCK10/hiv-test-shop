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
        .admins-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #34495e; color: white; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'จัดการแอดมิน'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> > จัดการแอดมิน
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-success">+ เพิ่มแอดมินใหม่</a>
        </div>

        <div class="admins-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>วันที่สร้าง</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>#{{ $admin->id }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-primary">แก้ไข</a>
                            @if($admin->id != 1)
                            <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('ต้องการลบแอดมินนี้?')">ลบ</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('script')

@endsection
