{{-- <!DOCTYPE html>
<html>
<head>
    <title>สั่งแบบฟรี - {{ $product->name }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        .btn { padding: 15px 30px; background: #27ae60; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; width: 100%; }
        .btn:hover { background: #229954; }
        .product-info { background: #e8f5e8; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .questionnaire { background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .question { margin-bottom: 15px; }
        .question label { font-weight: normal; margin-bottom: 5px; }
        .radio-group { display: flex; gap: 20px; margin-top: 10px; }
        .radio-group label { font-weight: normal; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        .btn { padding: 15px 30px; background: #27ae60; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 18px; width: 100%; }
        .btn:hover { background: #229954; }
        .product-info { background: #e8f5e8; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .questionnaire { background: #fff3cd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .question { margin-bottom: 15px; }
        .question label { font-weight: normal; margin-bottom: 5px; }
        .radio-group { display: flex; gap: 20px; margin-top: 10px; }
        .radio-group label { font-weight: normal; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])
    <div class="container">
        <div class="form-container">
            <div class="product-info">
                <h2>🆓 สั่งแบบฟรี: {{ $product->name }}</h2>
                <p><strong>ราคาปกติ:</strong> ฿{{ number_format($product->price) }}</p>
                <p><strong>ค่าจัดส่ง:</strong> ฿50</p>
                <p><strong>รวม:</strong> ฿50 (เฉพาะค่าส่ง)</p>
            </div>

            <form method="POST" action="{{ route('order.store-free') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="form-group">
                    <label>ชื่อ-สกุล *</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>เลขบัตรประชาชน *</label>
                    <input type="text" name="id_card" pattern="[0-9]{13}" maxlength="13" required>
                </div>

                <div class="form-group">
                    <label>เบอร์โทร *</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-group">
                    <label>ที่อยู่จัดส่ง *</label>
                    <textarea name="address" rows="3" required></textarea>
                </div>

                <div class="questionnaire">
                    <h3>📋 แบบประเมินความเสี่ยง (จำเป็นสำหรับการสั่งแบบฟรี)</h3>
                    
                    <div class="question">
                        <label>1. ท่านนิยามตนเองว่าเป็นกลุ่มประชากรใด</label>
                        <select name="q1" required>
                            <option value="">เลือกกลุ่มประชากร</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            <option value="ชายที่มีเพศสัมพันธ์กับชาย">ชายที่มีเพศสัมพันธ์กับชาย</option>
                            <option value="สาวประเภทสอง">สาวประเภทสอง</option>
                            <option value="ไบเซ็กชวล">ไบเซ็กชวล</option>
                            <option value="ไม่อยู่ในกรอบเพศชาย/หญิง">ไม่อยู่ในกรอบเพศชาย/หญิง</option>
                        </select>
                    </div>

                    <div class="question">
                        <label>2. ท่านเคยได้รับสิ่งของหรือเงิน เพื่อนำไปสู่การมีเพศสัมพันธ์หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q2" value="เคย" required> เคย</label>
                            <label><input type="radio" name="q2" value="ไม่เคย" required> ไม่เคย</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>3. ผลการตรวจเอชไอวี ครั้งล่าสุด</label>
                        <select name="q3" required>
                            <option value="">เลือกผลการตรวจ</option>
                            <option value="ไม่เคยตรวจ">ไม่เคยตรวจ</option>
                            <option value="เคยตรวจ แต่จำผลการตรวจไม่ได้">เคยตรวจ แต่จำผลการตรวจไม่ได้</option>
                            <option value="เคยตรวจ ผลไม่ติดเชื้อเอชไอวี (ลบ)">เคยตรวจ ผลไม่ติดเชื้อเอชไอวี (ลบ)</option>
                            <option value="เคยตรวจ ผลติดเชื้อเอชไอวี (บวก)">เคยตรวจ ผลติดเชื้อเอชไอวี (บวก)</option>
                            <option value="เคยตรวจ แต่สรุปผลไม่ได้">เคยตรวจ แต่สรุปผลไม่ได้</option>
                        </select>
                    </div>

                    <div class="question">
                        <label>4. เพศสัมพันธ์กับคู่นอน ในระยะ 3 เดือนที่ผ่านมา</label>
                        <select name="q4" required>
                            <option value="">เลือกประเภทคู่นอน</option>
                            <option value="กับคู่นอนประจำ เท่านั้น">กับคู่นอนประจำ เท่านั้น</option>
                            <option value="กับคู่นอนไม่ประจำ เท่านั้น">กับคู่นอนไม่ประจำ เท่านั้น</option>
                            <option value="กับคู่นอนประจำ และคู่นอนไม่ประจำ">กับคู่นอนประจำ และคู่นอนไม่ประจำ</option>
                            <option value="ไม่มีเพศสัมพันธ์">ไม่มีเพศสัมพันธ์</option>
                        </select>
                    </div>

                    <div class="question">
                        <label>5. บทบาททางเพศ</label>
                        <select name="q5" required>
                            <option value="">เลือกบทบาท</option>
                            <option value="รุกเท่านั้น">รุกเท่านั้น</option>
                            <option value="รับเท่านั้น">รับเท่านั้น</option>
                            <option value="ทั้งรุกทั้งรับ">ทั้งรุกทั้งรับ</option>
                            <option value="ไม่เคยมีเพศสัมพันธ์">ไม่เคยมีเพศสัมพันธ์</option>
                        </select>
                    </div>

                    <div class="question">
                        <label>6. ท่านมีเพศสัมพันธ์ครั้งล่าสุดทางช่องทางใด (สามารถตอบได้มากกว่า 1 ข้อ)</label>
                        <div style="display: flex; flex-direction: column; gap: 8px; margin-top: 10px;">
                            <label><input type="checkbox" name="q6[]" value="ทางทวารหนัก"> ทางทวารหนัก</label>
                            <label><input type="checkbox" name="q6[]" value="ทางช่องคลอดผู้หญิง"> ทางช่องคลอดผู้หญิง</label>
                            <label><input type="checkbox" name="q6[]" value="ทางช่องคลอดสาวประเภทสอง"> ทางช่องคลอดสาวประเภทสอง</label>
                            <label><input type="checkbox" name="q6[]" value="ทางปาก"> ทางปาก</label>
                            <label><input type="checkbox" name="q6[]" value="ไม่เคยมีเพศสัมพันธ์"> ไม่เคยมีเพศสัมพันธ์</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>7. การใช้ถุงยางอนามัย (ทั้งแบบรุก/แบบรับ) ในระยะ 3 เดือนที่ผ่านมา</label>
                        <select name="q7" required>
                            <option value="">เลือกการใช้ถุงยาง</option>
                            <option value="ใช้ถุงยางทุกครั้ง">ใช้ถุงยางทุกครั้ง</option>
                            <option value="ใช้ถุงยางเป็นบางครั้ง">ใช้ถุงยางเป็นบางครั้ง</option>
                            <option value="ไม่เคยใช้ถุงยางเลย">ไม่เคยใช้ถุงยางเลย</option>
                            <option value="ไม่เคยมีเพศสัมพันธ์">ไม่เคยมีเพศสัมพันธ์</option>
                        </select>
                    </div>

                    <div class="question">
                        <label>8. ในช่วง 3 เดือนที่ผ่านมาท่านมีเพศสัมพันธ์แบบสอดใส่(ทั้งแบบรุก/แบบรับ) หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q8" value="มีการสอดใส่" required> มีการสอดใส่</label>
                            <label><input type="radio" name="q8" value="ไม่มีการสอดใส่" required> ไม่มีการสอดใส่</label>
                            <label><input type="radio" name="q8" value="ไม่แน่ใจ" required> ไม่แน่ใจ</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>9. ในระยะ 3 เดือนที่ผ่านมา ท่านเคยใช้สารเสพติด Chemsex รวมถึงระหว่างมีเพศสัมพันธ์หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q9" value="เคยใช้สารเสพติด" required> เคยใช้สารเสพติด</label>
                            <label><input type="radio" name="q9" value="ไม่เคยใช้สารเสพติด" required> ไม่เคยใช้สารเสพติด</label>
                            <label><input type="radio" name="q9" value="ไม่แน่ใจ" required> ไม่แน่ใจ</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>10. ท่านเคยใช้เข็มฉีดยาหรือฉีดสารเสพติด ร่วมกับผู้อื่นหรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q10" value="เคยใช้เข็มร่วมกับผู้อื่น" required> เคยใช้เข็มร่วมกับผู้อื่น</label>
                            <label><input type="radio" name="q10" value="ไม่เคยใช้เข็มร่วมกับผู้อื่น" required> ไม่เคยใช้เข็มร่วมกับผู้อื่น</label>
                            <label><input type="radio" name="q10" value="จำไม่ได้" required> จำไม่ได้</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>11. ในระยะ 3 เดือนที่ผ่านมา ท่านมีอาการผิดปกติ เช่นแผล ตุ่ม หนอง ที่อวัยวะเพศหรือทวารหนัก หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q11" value="เคยมี รักษาหายแล้ว" required> เคยมี รักษาหายแล้ว</label>
                            <label><input type="radio" name="q11" value="มีในขณะนี้" required> มีในขณะนี้</label>
                            <label><input type="radio" name="q11" value="ไม่เคยมีอาการ" required> ไม่เคยมีอาการ</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>12. ท่านรู้จัก ยา PrEP (ยาป้องกันเอชไอวี ก่อนสัมผัสเชื้อ) หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q12" value="รู้จัก ยา PrEP" required> รู้จัก ยา PrEP</label>
                            <label><input type="radio" name="q12" value="ไม่รู้จัก ยา PrEP" required> ไม่รู้จัก ยา PrEP</label>
                        </div>
                    </div>

                    <div class="question">
                        <label>13. ท่านรู้จัก ยา PEP (ยาป้องกันเอชไอวี แบบฉุกเฉิน) หรือไม่</label>
                        <div class="radio-group">
                            <label><input type="radio" name="q13" value="รู้จัก ยา PEP" required> รู้จัก ยา PEP</label>
                            <label><input type="radio" name="q13" value="ไม่รู้จัก ยา PEP" required> ไม่รู้จัก ยา PEP</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn">📦 สั่งซื้อแบบฟรี (จ่ายเฉพาะค่าส่ง ฿50)</button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}">← กลับหน้าแรก</a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
@endsection