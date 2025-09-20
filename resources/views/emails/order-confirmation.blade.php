<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ยืนยันการสั่งซื้อ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kanit', Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #27ae60; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .order-details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { background: #34495e; color: white; padding: 15px; text-align: center; border-radius: 0 0 8px 8px; }
        .status { padding: 8px 15px; border-radius: 20px; color: white; display: inline-block; }
        .status.confirmed { background: #27ae60; }
        .status.pending { background: #f39c12; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 ยืนยันการสั่งซื้อ</h1>
            <p>HIV Test Shop</p>
        </div>
        
        <div class="content">
            <p>สวัสดีคุณ <strong>{{ $order->name }}</strong>,</p>
            
            <p>ขอบคุณที่สั่งซื้อสินค้ากับเรา เราได้รับคำสั่งซื้อของคุณเรียบร้อยแล้ว</p>
            
            <div class="order-details">
                <h3>รายละเอียดคำสั่งซื้อ #{{ $order->id }}</h3>
                <p><strong>สินค้า:</strong> {{ $order->product->name }}</p>
                <p><strong>ประเภท:</strong> {{ $order->is_free ? 'สั่งแบบฟรี (จ่ายเฉพาะค่าส่ง)' : 'สั่งซื้อปกติ' }}</p>
                <p><strong>ยอดรวม:</strong> ฿{{ number_format($order->total_amount) }}</p>
                <p><strong>สถานะ:</strong> 
                    <span class="status {{ $order->status }}">
                        {{ $order->status == 'confirmed' ? 'ยืนยันแล้ว' : 'รอการชำระเงิน' }}
                    </span>
                </p>
                <p><strong>ที่อยู่จัดส่ง:</strong> {{ $order->address }}</p>
            </div>
            
            @if($order->status == 'pending')
            <p><strong>⚠️ กรุณาชำระเงินภายใน 24 ชั่วโมง</strong></p>
            <p>หากชำระเงินเรียบร้อยแล้ว กรุณาอัพโหลดสลิปการโอนเงินในระบบ</p>
            @else
            <p>✅ เราจะดำเนินการจัดส่งสินค้าให้คุณโดยเร็วที่สุด</p>
            @endif
            
            <p>หากมีข้อสงสัย กรุณาติดต่อเราได้ที่ admin@hivtestshop.com</p>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 HIV Test Shop - ดูแลสุขภาพของคุณ</p>
        </div>
    </div>
</body>
</html>