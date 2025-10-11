<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ออเดอร์ใหม่</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3498db; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .order-details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { background: #34495e; color: white; padding: 15px; text-align: center; border-radius: 0 0 8px 8px; }
        .urgent { background: #e74c3c; color: white; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 ออเดอร์ใหม่</h1>
            <p>HIV Test Shop Admin</p>
        </div>
        
        <div class="content">
            @if($order->status == 'pending')
            <div class="urgent">
                ⚠️ ออเดอร์นี้รอการชำระเงิน - กรุณาติดตามการชำระ
            </div>
            @endif
            
            <div class="order-details">
                <h3>รายละเอียดออเดอร์ #{{ $order->id }}</h3>
                <p><strong>ลูกค้า:</strong> {{ $order->name }}</p>
                <p><strong>เบอร์โทร:</strong> {{ $order->phone }}</p>
                <p><strong>อีเมล:</strong> {{ $order->email }}</p>
                @if($order->orderItems && $order->orderItems->count() > 0)
                    <p><strong>สินค้า:</strong></p>
                    @foreach($order->orderItems as $item)
                        <p style="margin-left: 20px;">
                            - {{ $item->product->name }} x{{ $item->quantity }}
                            @if($item->is_free)
                                <span style="color: #27ae60;">(Free)</span>
                            @else
                                (฿{{ number_format($item->price * $item->quantity) }})
                            @endif
                        </p>
                    @endforeach
                @else
                    <p><strong>สินค้า:</strong> {{ $order->product->name ?? 'N/A' }}</p>
                @endif
                <p><strong>ประเภท:</strong> {{ $order->is_free ? 'สั่งแบบฟรี' : 'สั่งซื้อปกติ' }}</p>
                <p><strong>ยอดรวม:</strong> ฿{{ number_format($order->total_amount) }}</p>
                <p><strong>สถานะ:</strong> {{ $order->status == 'confirmed' ? 'ยืนยันแล้ว' : 'รอการชำระเงิน' }}</p>
                <p><strong>ที่อยู่จัดส่ง:</strong> {{ $order->address }}</p>
                <p><strong>วันที่สั่ง:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            @if($order->is_free && $order->questionnaire)
            <div class="order-details">
                <h4>ข้อมูลแบบสอบถาม (สำหรับออเดอร์ฟรี)</h4>
                <p><strong>เลขบัตรประชาชน:</strong> {{ $order->id_card }}</p>
                <p><em>มีข้อมูลแบบสอบถามเพิ่มเติมในระบบ</em></p>
            </div>
            @endif
            
            <p><strong>การดำเนินการต่อไป:</strong></p>
            <ul>
                @if($order->status == 'pending')
                <li>ติดตามการชำระเงินจากลูกค้า</li>
                <li>ตรวจสอบสลิปการโอนเงิน (หากมี)</li>
                @endif
                <li>เตรียมสินค้าสำหรับจัดส่ง</li>
                <li>ติดต่อลูกค้าหากจำเป็น</li>
            </ul>
        </div>
        
        <div class="footer">
            <p>HIV Test Shop Admin Panel</p>
        </div>
    </div>
</body>
</html>