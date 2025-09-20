<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #3498db; text-decoration: none; margin-right: 15px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 36px; font-weight: bold; color: #3498db; }
        .orders-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #34495e; color: white; }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status.pending { background: #f39c12; color: white; }
        .status.confirmed { background: #27ae60; color: white; }
        .status.completed { background: #3498db; color: white; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 11px; }
        .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #ff0000; color: white; }
        .logout { color: white; text-decoration: none; padding: 10px 20px; background: #ff0000; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">จัดการสินค้า</a>
            <a href="{{ route('admin.questionnaire.report') }}" class="btn btn-primary">รายงานแบบสอบถาม</a>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">จัดการแอดมิน</a>
            <a href="{{ route('admin.profile') }}" class="btn btn-primary">โปรไฟล์</a>
            <a href="{{ route('admin.logout') }}" class="logout">ออกจากระบบ</a>
        </div>
    </div>

    <div class="container">
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ $totalOrders }}</div>
                <div>คำสั่งซื้อทั้งหมด</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $freeOrders }}</div>
                <div>คำสั่งซื้อแบบฟรี</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $paidOrders }}</div>
                <div>คำสั่งซื้อแบบจ่ายเงิน</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">฿{{ number_format($totalRevenue) }}</div>
                <div>รายได้รวม</div>
            </div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ค้นหา</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ชื่อลูกค้า, เบอร์, สินค้า" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">สถานะ</label>
                    <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">ทั้งหมด</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รอชำระ</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>ยืนยันแล้ว</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ประเภท</label>
                    <select name="type" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">ทั้งหมด</option>
                        <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>ฟรี</option>
                        <option value="0" {{ request('type') == '0' ? 'selected' : '' }}>จ่ายเงิน</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ตั้งแต่วันที่</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ถึงวันที่</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #6c757d; color: white;">ล้าง</a>
                </div>
            </form>
        </div>

        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ลูกค้า</th>
                        <th>สินค้า</th>
                        <th>ประเภท</th>
                        <th>ยอดรวม</th>
                        <th>สถานะ</th>
                        <th>วันที่</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            <strong>{{ $order->name }}</strong><br>
                            <small>{{ $order->phone }}</small>
                        </td>
                        <td>{{ $order->product->name }}</td>
                        <td>
                            @if($order->is_free)
                                <span class="free-badge">ฟรี</span>
                            @else
                                จ่ายเงิน
                            @endif
                        </td>
                        <td>฿{{ number_format($order->total_amount) }}</td>
                        <td>
                            <span class="status {{ $order->status }}">
                                @if($order->status == 'pending') รอชำระ
                                @elseif($order->status == 'confirmed') ยืนยันแล้ว
                                @elseif($order->status == 'completed') เสร็จสิ้น
                                @endif
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary">ดู</a>
                            @if($order->status == 'pending')
                                <a href="{{ route('admin.order.confirm', $order->id) }}" class="btn btn-success">ยืนยัน</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
