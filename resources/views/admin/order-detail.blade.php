@extends('layouts.authTemplate')

@section('css')
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; } */
        .order-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .status { padding: 8px 15px; border-radius: 20px; font-weight: bold; }
        .status.pending { background: #f39c12; color: white; }
        .status.confirmed { background: #27ae60; color: white; }
        .status.completed { background: #3498db; color: white; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .info-item { padding: 15px; background: #f8f9fa; border-radius: 8px; }
        .info-label { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .questionnaire { background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .question { margin-bottom: 15px; }
        .question strong { color: #2c3e50; }
        /* .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-secondary { background: #6c757d; color: white; } */
        .back-link { margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'รายละเอียดคำสั่งซื้อ #'.$order->id
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> >
            <a href="{{ route('admin.dashboard') }}">คำสั่งซื้อ</a> > รายละเอียดคำสั่งซื้อ #{{ $order->order_no }}
        </div>

        <h3>รายละเอียดคำสั่งซื้อ #{{ $order->order_no }}</h3>
        <div class="order-card">
            <div class="order-header">
                <div>
                    <h2>คำสั่งซื้อ #{{ $order->order_no }}</h2>
                    @if($order->orderItems && $order->orderItems->count() > 0)
                        <div style="margin-top: 10px;">
                            @foreach($order->orderItems as $item)
                                <div style="font-size: 14px; color: #666; margin-bottom: 5px;">
                                    {{ $item->product->name }} x{{ $item->quantity }}
                                    @if($item->is_free)
                                        <span style="color: #27ae60; font-weight: bold;">(Free)</span>
                                    @else
                                        (฿{{ number_format($item->price * $item->quantity) }})
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #666; margin-top: 5px;">{{ $order->product->name ?? 'N/A' }}</p>
                    @endif
                </div>
                <span class="status {{ $order->status }}">
                    @if($order->status == 'pending') รอชำระ
                    @elseif($order->status == 'confirmed') ยืนยันแล้ว
                    @elseif($order->status == 'completed') เสร็จสิ้น
                    @endif
                </span>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">เลขที่คำสั่งซื้อ</div>
                    <div>{{ $order->order_no}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">ชื่อลูกค้า</div>
                    <div>{{ $order->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">เบอร์โทร</div>
                    <div>{{ $order->phone }}</div>
                </div>
                @if($order->id_card)
                <div class="info-item">
                    <div class="info-label">เลขบัตรประชาชน</div>
                    <div>{{ $order->id_card }}</div>
                </div>
                @endif
                <div class="info-item">
                    <div class="info-label">ประเภทคำสั่งซื้อ</div>
                    <div>
                        @if($order->is_free)
                            <span style="color: #27ae60; font-weight: bold;">แบบฟรี</span>
                        @else
                            <span style="color: #3498db; font-weight: bold;">จ่ายเงิน</span>
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">ยอดรวม</div>
                    <div style="font-size: 20px; font-weight: bold; color: #ff0000;">฿{{ number_format($order->total_amount) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">วันที่สั่ง</div>
                    <div>{{ $order->created_at->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">ที่อยู่จัดส่ง</div>
                <div>{{ $order->address }}</div>
            </div>

            @if($order->payment_slip)
            <div class="info-item" style="grid-column: 1 / -1;">
                <div class="info-label">สลิปการชำระเงิน</div>
                <div style="margin-top: 10px;">
                    <img src="{{ asset('storage/' . $order->payment_slip) }}" 
                         alt="Payment Slip" 
                         style="max-width: 300px; max-height: 400px; border-radius: 8px; border: 1px solid #ddd; cursor: pointer;"
                         onclick="window.open(this.src, '_blank')">
                    <p style="margin-top: 5px; color: #666; font-size: 14px;">คลิกเพื่อดูขนาดเต็ม</p>
                </div>
            </div>
            @endif

            @if($order->questionnaire)
            <div class="questionnaire">
                <h3>คำตอบแบบสอบถาม</h3>
                @foreach($order->questionnaire->answers as $key => $answer)
                <div class="question">
                    <strong>
                        @if($key == 'q1') ท่านนิยามตนเองว่าเป็นกลุ่มประชากรใด:
                        @elseif($key == 'q2') ท่านเคยได้รับสิ่งของหรือเงิน เพื่อนำไปสู่การมีเพศสัมพันธ์หรือไม่:
                        @elseif($key == 'q3') ผลการตรวจเอชไอวี ครั้งล่าสุด:
                        @elseif($key == 'q4') เพศสัมพันธ์กับคู่นอน ในระยะ 3 เดือนที่ผ่านมา:
                        @elseif($key == 'q5') บทบาททางเพศ:
                        @elseif($key == 'q6') ท่านมีเพศสัมพันธ์ครั้งล่าสุดทางช่องทางใด:
                        @elseif($key == 'q7') การใช้ถุงยางอนามัย ในระยะ 3 เดือนที่ผ่านมา:
                        @elseif($key == 'q8') ในช่วง 3 เดือนที่ผ่านมาท่านมีเพศสัมพันธ์แบบสอดใส่หรือไม่:
                        @elseif($key == 'q9') ในระยะ 3 เดือนที่ผ่านมา ท่านเคยใช้สารเสพติด Chemsex หรือไม่:
                        @elseif($key == 'q10') ท่านเคยใช้เข็มฉีดยาหรือฉีดสารเสพติด ร่วมกับผู้อื่นหรือไม่:
                        @elseif($key == 'q11') ในระยะ 3 เดือนที่ผ่านมา ท่านมีอาการผิดปกติที่อวัยวะเพศหรือทวารหนักหรือไม่:
                        @elseif($key == 'q12') ท่านรู้จัก ยา PrEP หรือไม่:
                        @elseif($key == 'q13') ท่านรู้จัก ยา PEP หรือไม่:
                        @endif
                    </strong>
                    <span class="success">{{ $answer }}</span>
                </div>
                @endforeach
            </div>
            @endif

            <div style="text-align: center; margin-top: 30px;">
                @if($order->status == 'pending')
                    <a href="{{ route('admin.order.confirm', $order->id) }}" class="btn btn-success">ยืนยันคำสั่งซื้อ</a>
                @endif
                @if($order->status == 'confirmed')
                    <a href="{{ route('admin.order.complete', $order->id) }}" class="btn btn-primary">ทำเครื่องหมายเสร็จสิ้น</a>
                @endif
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">กลับ Dashboard</a>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
