@extends('layouts.authTemplate')

@section('css')

@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'Admin Dashboard'
    ])

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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="เลขที่คำสั่งซื้อ, ชื่อลูกค้า, เบอร์, สินค้า" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
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
                    <input type="date" name="date_from" value="{{ htmlspecialchars(request('date_from')) }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">ถึงวันที่</label>
                    <input type="date" name="date_to" value="{{ htmlspecialchars(request('date_to')) }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
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
                        <th style="width: 200px;">เลขที่คำสั่งซื้อ</th>
                        <th>ลูกค้า</th>
                        <th style="width: 200px;">สินค้า</th>
                        <th style="width: 200px;">ประเภท</th>
                        <th style="width: 200px;">ยอดรวม</th>
                        <th style="width: 200px;">สถานะ</th>
                        <th style="width: 200px;">วันที่</th>
                        <th style="width: 200px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->order_no }}</td>
                        <td>
                            <strong>{{ $order->name }}</strong><br>
                            <small>{{ $order->phone }}</small>
                        </td>
                        <td>{{ $order->product?->name ?? 'N/A' }}</td>
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


@endsection

@section('script')

@endsection
