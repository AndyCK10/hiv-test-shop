{{-- <!DOCTYPE html>
<html>
<head>
    <title>ชำระเงิน</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .payment-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .amount { font-size: 36px; font-weight: bold; color: #ff0000; margin: 20px 0; }
        .bank-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 30px 0; }
        .bank-btn { padding: 15px; border: none; border-radius: 10px; cursor: pointer; font-size: 16px; font-weight: bold; color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .scb { background: #4e2a84; }
        .kbank { background: #138f2d; }
        .bbl { background: #1e4598; }
        .ktb { background: #1ba1e6; }
        .bay { background: #fec43b; color: #333; }
        .gsb { background: #eb6101; }
        .bank-btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .instructions { background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left; }
        .back-link { margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .payment-container { padding: 20px; }
            .bank-buttons { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .payment-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .amount { font-size: 36px; font-weight: bold; color: #ff0000; margin: 20px 0; }
        .bank-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin: 30px 0; }
        .bank-btn { padding: 12px 15px; border: none; border-radius: 25px; cursor: pointer; font-size: 16px; color: white; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .scb { background: #4e2a84; }
        .kbank { background: #138f2d; }
        .bbl { background: #1e4598; }
        .ktb { background: #1ba1e6; }
        .bay { background: #fec43b; color: #333; }
        .gsb { background: #eb6101; }
        .bank-btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .instructions { background: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: left; }
        .back-link { margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .payment-container { padding: 20px; }
            .bank-buttons { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    <div class="container">
        <div class="payment-container">
            <h1>ชำระเงิน</h1>

            <div class="order-summary">
                <h3>รายละเอียดคำสั่งซื้อ #{{ $order->id }}</h3>
                <p><strong>สินค้า:</strong> {{ $order->product->name }}</p>
                <p><strong>ลูกค้า:</strong> {{ $order->name }}</p>
                <div class="amount">฿{{ number_format($order->total_amount) }}</div>
            </div>

            <div class="instructions">
                <h4>วิธีการชำระเงิน:</h4>
                <ol>
                    <li>เลือกธนาคารที่ต้องการ</li>
                    <li>แอปธนาคารจะเปิดขึ้นพร้อมยอดเงิน</li>
                    <li>กดยืนยันการชำระเงิน</li>
                    <li>กลับมาที่ระบบและอัพโหลดสลิปเพื่อยืนยืนการชำระเงิน</li>
                </ol>
            </div>

            <!-- Bank Account Information -->
            <div style="margin: 30px 0; padding: 20px; background: #e8f5e8; border-radius: 8px; border-left: 4px solid #27ae60;">
                <h4>ข้อมูลบัญชีสำหรับโอนเงิน</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 15px;">
                    <div style="background: white; padding: 15px; border-radius: 8px; text-align: left;">
                        <div style="color: #138f2d; font-weight: bold; margin-bottom: 5px;">ธนาคารกสิกรไทย</div>
                        <div><strong>ชื่อบัญชี:</strong> HIVST</div>
                        <div style="display: flex; align-items: center; gap: 10px;"><strong>เลขที่บัญชี:</strong> <span style="font-family: monospace; background: #f0f0f0; padding: 2px 5px; border-radius: 3px;">123-4-56789-0</span> <button onclick="copyToClipboard('1234567890')" style="background: #138f2d; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;">📋</button></div>
                        <div><strong>ประเภท:</strong> ออมทรัพย์</div>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 8px; text-align: left;">
                        <div style="color: #4e2a84; font-weight: bold; margin-bottom: 5px;">ธนาคารไทยพาณิชย์</div>
                        <div><strong>ชื่อบัญชี:</strong> HIVST</div>
                        <div style="display: flex; align-items: center; gap: 10px;"><strong>เลขที่บัญชี:</strong> <span style="font-family: monospace; background: #f0f0f0; padding: 2px 5px; border-radius: 3px;">987-6-54321-0</span> <button onclick="copyToClipboard('9876543210')" style="background: #4e2a84; color: white; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;">📋</button></div>
                        <div><strong>ประเภท:</strong> ออมทรัพย์</div>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 15px;">
                    <p><strong>ยอดที่ต้องโอน:</strong> <span style="color: #ff0000; font-size: 20px; font-weight: bold;">฿{{ number_format($order->total_amount) }}</span></p>
                    <p style="display: flex; align-items: center; justify-content: center; gap: 10px;"><strong>เลขที่คำสั่งซื้อ:</strong> <span style="font-family: monospace; background: #fff3cd; padding: 5px 10px; border-radius: 5px; font-weight: bold;">#{{ $order->id }}</span> <button onclick="copyToClipboard('{{ $order->id }}')" style="background: #ffc107; color: #333; border: none; padding: 4px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;">📋</button></p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div style="margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center;">
                <h4>QR Code สำหรับโอนเงิน</h4>
                <div style="display: inline-block; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    {{-- <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=00020101021230570016A000000677010111011300668123456789054{{ str_pad($order->total_amount * 100, 10, '0', STR_PAD_LEFT) }}5802TH6304" 
                         alt="QR Code" 
                         style="width: 200px; height: 200px; border: 1px solid #ddd; border-radius: 8px;"> --}}
                    <img src="https://promptpay.io/{{ $bank_qr_code }}/{{ $order->total_amount }}" 
                         alt="QR Code" 
                         style="width: 200px; height: 200px; border: 1px solid #ddd; border-radius: 8px;">
                    <p style="margin-top: 10px; color: #666; font-size: 14px;">สแกน QR Code เพื่อโอนเงิน</p>
                    <p style="color: #ff0000; font-weight: bold;">฿{{ number_format($order->total_amount) }}</p>
                </div>
                <p style="margin-top: 15px; color: #666; font-size: 14px;">⚠️ QR Code นี้ใช้ได้กับแอปธนาคารส่วนใหญ่</p>
            </div>

            <h3>เลือกธนาคาร</h3>
            <div class="bank-buttons">
                <a href="scbeasy://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn scb">
                    SCB Easy
                </a>
                <a href="kplus://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn kbank">
                    K PLUS
                </a>
                <a href="bualuang://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn bbl">
                    Bualuang
                </a>
                <a href="krungthai://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn ktb">
                    Krungthai
                </a>
                <a href="krungsribank://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn bay">
                    KMA
                </a>
                <a href="gsb://payment?amount={{ $order->total_amount }}&ref={{ $order->id }}&callback={{ urlencode(route('payment.success', $order->id)) }}" class="bank-btn gsb">
                    GSB
                </a>
            </div>

            <!-- Upload Slip Section -->
            <div style="margin: 30px 0; padding: 20px; background: #fff3cd; border-radius: 8px; border: 2px dashed #ffc107;">
                <h4>อัพโหลดสลิปการโอนเงิน</h4>
                <p style="color: #856404; margin-bottom: 15px; font-size: 14px;">กรุณาอัพโหลดสลิปหลังจากโอนเงินเรียบร้อยแล้ว</p>
                <form action="{{ route('payment.upload-slip', $order->id) }}" method="POST" enctype="multipart/form-data" id="slipForm">
                    @csrf
                    <div style="margin: 15px 0;">
                        <input type="file" name="payment_slip" accept="image/*" required 
                               style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                        <small style="color: #666;">รองรับไฟล์: JPG, PNG, GIF (ขนาดไม่เกิน 2MB)</small>
                    </div>
                    <div id="slip_preview"></div>
                    {{-- todo --}}
                    <div style="margin: 15px 0; display: none;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" id="autoVerify">
                            <span style="font-size: 14px;">🤖 ตรวจสอบสลิปอัตโนมัติ (แนะนำ)</span>
                        </label>
                        <small style="color: #666; display: block; margin-top: 5px;">ระบบจะตรวจสอบยอดเงินและเวลาในสลิปอัตโนมัติ</small>
                    </div>
                    <div id="verificationResult" style="margin: 15px 0; padding: 10px; border-radius: 5px; display: none;"></div>
                    <button type="submit" class="btn btn-success" id="submitBtn" style="width: 100%; margin-top: 10px;">
                        อัพโหลดสลิปเพื่อยืนยันการชำระ
                    </button>
                </form>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <span style="color: #666;">หรือ</span>
            </div>

            <a href="{{ route('payment.success', $order->id) }}" class="btn btn-secondary" style="width: 100%;">
                ข้ามการอัพโหลดสลิป
            </a>

            <div class="back-link">
                <a href="{{ route('home') }}">กลับหน้าแรก</a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Fallback for mobile apps that don't support deep linking
        document.querySelectorAll('.bank-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                // setTimeout(() => {
                //     if (confirm('หากแอปธนาคารไม่เปิด กดตกลงเพื่อไปหน้าขอบคุณ')) {
                //         window.location.href = '{{ route("payment.success", $order->id) }}';
                //     }
                // }, 3000);
            });
        });

        // Image preview and verification for slip upload
        document.querySelector('input[name="payment_slip"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Remove existing preview
                const existingPreview = document.getElementById('slipPreview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.id = 'slipPreview';
                    preview.innerHTML = `
                        <div style="margin-top: 15px; text-align: center;">
                            <img src="${e.target.result}" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                            <p style="margin-top: 5px; color: #666; font-size: 14px;">ตัวอย่างสลิป</p>
                        </div>
                    `;
                    document.getElementById('slip_preview').appendChild(preview);

                    // Auto verify if enabled
                    if (document.getElementById('autoVerify').checked) {
                        verifySlip(e.target.result);
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Slip verification function
        async function verifySlip(imageData) {
            const resultDiv = document.getElementById('verificationResult');
            const submitBtn = document.getElementById('submitBtn');
            
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = `
                <div style="text-align: center; color: #666;">
                    <div style="display: inline-block; width: 20px; height: 20px; border: 2px solid #f3f3f3; border-top: 2px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    <p style="margin-top: 10px;">🔍 กำลังตรวจสอบสลิป...</p>
                </div>
            `;
            
            try {
                // Call actual API
                const response = await fetch('{{ route("payment.verify-slip", $order->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        slip_image: imageData
                    })
                });
                
                const verification = await response.json();
                
                if (verification.success) {
                    resultDiv.innerHTML = `
                        <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 20px;">✅</span>
                                <div>
                                    <strong>ตรวจสอบสำเร็จ!</strong>
                                    <div style="font-size: 14px; margin-top: 5px;">
                                        ยอดเงิน: ฿${verification.amount.toLocaleString()}<br>
                                        เวลา: ${verification.time}<br>
                                        ธนาคาร: ${verification.bank}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    submitBtn.style.background = '#28a745';
                    submitBtn.innerHTML = 'ยืนยันการชำระเงิน';
                } else {
                    resultDiv.innerHTML = `
                        <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-size: 20px;">⚠️</span>
                                <div>
                                    <strong>ตรวจสอบไม่ผ่าน</strong>
                                    <div style="font-size: 14px; margin-top: 5px;">
                                        ${verification.error}<br>
                                        คุณสามารถอัพโหลดต่อไปได้
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    submitBtn.style.background = '#ffc107';
                    submitBtn.innerHTML = '⚠️ อัพโหลดสลิปต่อไป';
                }
            } catch (error) {
                resultDiv.innerHTML = `
                    <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 20px;">❌</span>
                            <div>
                                <strong>เกิดข้อผิดพลาด</strong>
                                <div style="font-size: 14px; margin-top: 5px;">
                                    ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }



        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('คัดลอกเลขบัญชีแล้ว! ' + text);
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('คัดลอกเลขบัญชีแล้ว! ' + text);
            });
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 12px 20px;
                border-radius: 5px;
                z-index: 10000;
                font-size: 14px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                animation: slideIn 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-in';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 2000);
        }

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
