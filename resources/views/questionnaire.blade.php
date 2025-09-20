{{-- <!DOCTYPE html>
<html>
<head>
    <title>แบบประเมินความเสี่ยงโรคติดต่อทางเพศสัมพันธ์ ด้วยตนเอง</title>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .navbar { background: #2c3e50; padding: 15px 0; }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-menu { display: flex; gap: 30px; }
        .nav-menu a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .nav-menu a:hover { color: #3498db; }
        .nav-menu a.active { color: #3498db; }
        .hamburger { display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: white; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-5px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-5px, -6px); }
        .cart-link { background: #3498db; color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; position: relative; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #ff0000; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        .question { margin-bottom: 25px; padding: 20px; background: #f8f9fa; border-radius: 8px; }
        .question label { font-weight: bold; margin-bottom: 15px; }
        .radio-group { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px; }
        .radio-group label { font-weight: normal; display: flex; align-items: center; gap: 8px; }
        .checkbox-group { display: flex; flex-direction: column; gap: 8px; margin-top: 10px; }
        .checkbox-group label { font-weight: normal; display: flex; align-items: center; gap: 8px; }
        .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-success { background: #27ae60; color: white; width: 100%; }
        .btn-secondary { background: #6c757d; color: white; }
        .progress { background: #e9ecef; border-radius: 10px; height: 10px; margin-bottom: 20px; }
        .progress-bar { background: #27ae60; height: 100%; border-radius: 10px; transition: width 0.3s; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #2c3e50; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .container { padding: 10px; }
            .form-container { padding: 20px; }
            .form-group { margin-bottom: 15px; }
            .btn { width: 100%; margin: 10px 0; }
            .radio-group { flex-direction: column; gap: 10px; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link { padding: 8px 15px; font-size: 14px; }
            .header h1 { font-size: 24px; }
            input, textarea, select { font-size: 16px; }
            .checkbox-group { gap: 5px; }
            .question { padding: 15px; }
        }
    </style>
</head>
<body> --}}
@extends('layouts.appTemplate')

@section('css')
    <style>
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }

        .question {
            margin-bottom: 5px;
            /* padding: 20px;  */
            background: #f8f9fa;
            border-radius: 8px;
        }
        .question label { font-weight: bold; margin-bottom: 15px; }
        .radio-group {
            /* display: flex;
            flex-wrap: wrap;  */
            display: grid;
            grid-template-columns: 1fr;
            /* gap: 2px;
            margin-top: 10px;  */
        }
        .radio-group label { font-weight: normal; display: flex; align-items: center; gap: 8px; }
        .checkbox-group { display: flex; flex-direction: column; gap: 8px; margin-top: 10px; }
        .checkbox-group label { font-weight: normal; display: flex; align-items: center; gap: 8px; }
        /* .btn { padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-success { background: #27ae60; color: white; width: 100%; }
        .btn-secondary { background: #6c757d; color: white; } */
        .progress { background: #e9ecef; border-radius: 10px; height: 10px; margin-bottom: 20px; }
        .progress-bar { background: #27ae60; height: 100%; border-radius: 10px; transition: width 0.3s; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .form-container { padding: 20px; }
            .form-group { margin-bottom: 15px; }
            .btn { width: 100%; margin: 10px 0; }
            .radio-group { flex-direction: column; }
            input[type="text"], input[type="tel"]{ width: 100%; }
        }
        @media (max-width: 480px) {
            .header h1 { font-size: 24px; }
            input, textarea, select { font-size: 16px; }
            .checkbox-group { gap: 5px; }
            .question { padding: 15px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('uc.menu', [
        'cartCount' =>  $cartCount
    ])

    <div class="container">
        <div class="form-container">
            <div class="header">
                <h1>แบบประเมินความเสี่ยงโรคติดต่อทางเพศสัมพันธ์ ด้วยตนเอง</h1>
                <p>กรุณาตอบแบบสอบถามเพื่อรับสินค้าฟรี</p>
            </div>

            <div class="progress">
                <div class="progress-bar" style="width: 0%" id="progressBar"></div>
            </div>

            <form method="POST" action="{{ route('questionnaire.store') }}">
                @csrf
                {{-- @if(isset($productId))
                    <input type="hidden" name="product_id" value="{{ $productId }}">
                @endif --}}

                <div style="background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; color: #1976d2;">ข้อมูลส่วนตัว</h3>

                    <div class="form-group">
                        <label>ชื่อ-สกุล *</label>
                        <input type="text" name="name" required onchange="updateProgress()">
                    </div>

                    <div class="form-group">
                        <label>เลขบัตรประชาชน *</label>
                        <input type="text" name="id_card" pattern="[0-9]{13}" maxlength="13" required onchange="updateProgress()">
                    </div>

                    <div class="form-group">
                        <label>เบอร์โทร *</label>
                        <input type="tel" name="phone" required onchange="updateProgress()">
                    </div>
                </div>

                <h3>แบบประเมินความเสี่ยง</h3>
                <div class="question">
                    <label>1. ท่านนิยามตนเองว่าเป็นกลุ่มประชากรใด</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q1" value="ชาย" required onchange="updateProgress()"> ชาย</label>
                        <label><input type="radio" name="q1" value="หญิง" required onchange="updateProgress()"> หญิง</label>
                        <label><input type="radio" name="q1" value="ชายที่มีเพศสัมพันธ์กับชาย" required onchange="updateProgress()"> ชายที่มีเพศสัมพันธ์กับชาย</label>
                        <label><input type="radio" name="q1" value="สาวประเภทสอง" required onchange="updateProgress()"> สาวประเภทสอง</label>
                        <label><input type="radio" name="q1" value="ไบเซ็กชวล" required onchange="updateProgress()"> ไบเซ็กชวล</label>
                        <label><input type="radio" name="q1" value="ไม่อยู่ในกรอบเพศชาย/หญิง" required onchange="updateProgress()"> ไม่อยู่ในกรอบเพศชาย/หญิง</label>
                    </div>
                </div>

                <div class="question">
                    <label>2. ท่านเคยได้รับสิ่งของหรือเงิน เพื่อนำไปสู่การมีเพศสัมพันธ์หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q2" value="เคย" required onchange="updateProgress()"> เคย</label>
                        <label><input type="radio" name="q2" value="ไม่เคย" required onchange="updateProgress()"> ไม่เคย</label>
                    </div>
                </div>

                <div class="question">
                    <label>3. ผลการตรวจเอชไอวี ครั้งล่าสุด</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q3" value="ไม่เคยตรวจ" required onchange="updateProgress()"> ไม่เคยตรวจ</label>
                        <label><input type="radio" name="q3" value="เคยตรวจ แต่จำผลการตรวจไม่ได้" required onchange="updateProgress()"> เคยตรวจ แต่จำผลการตรวจไม่ได้</label>
                        <label><input type="radio" name="q3" value="เคยตรวจ ผลไม่ติดเชื้อเอชไอวี (ลบ)" required onchange="updateProgress()"> เคยตรวจ ผลไม่ติดเชื้อเอชไอวี (ลบ)</label>
                        <label><input type="radio" name="q3" value="เคยตรวจ ผลติดเชื้อเอชไอวี (บวก)" required onchange="updateProgress()"> เคยตรวจ ผลติดเชื้อเอชไอวี (บวก)</label>
                        <label><input type="radio" name="q3" value="เคยตรวจ แต่สรุปผลไม่ได้" required onchange="updateProgress()"> เคยตรวจ แต่สรุปผลไม่ได้</label>
                    </div>
                </div>

                <div class="question">
                    <label>4. เพศสัมพันธ์กับคู่นอน ในระยะ 3 เดือนที่ผ่านมา</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q4" value="กับคู่นอนประจำ เท่านั้น" required onchange="updateProgress()"> กับคู่นอนประจำ เท่านั้น</label>
                        <label><input type="radio" name="q4" value="กับคู่นอนประจำ เท่านั้น" required onchange="updateProgress()"> กับคู่นอนประจำ เท่านั้น</label>
                        <label><input type="radio" name="q4" value="กับคู่นอนไม่ประจำ เท่านั้น" required onchange="updateProgress()"> กับคู่นอนไม่ประจำ เท่านั้น</label>
                        <label><input type="radio" name="q4" value="ไม่มีเพศสัมพันธ์" required onchange="updateProgress()"> ไม่มีเพศสัมพันธ์</label>
                    </div>
                </div>

                <div class="question">
                    <label>5. บทบาททางเพศ</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q5" value="รุกเท่านั้น" required onchange="updateProgress()"> รุกเท่านั้น</label>
                        <label><input type="radio" name="q5" value="รับเท่านั้น" required onchange="updateProgress()"> รับเท่านั้น</label>
                        <label><input type="radio" name="q5" value="ทั้งรุกทั้งรับ" required onchange="updateProgress()"> ทั้งรุกทั้งรับ</label>
                        <label><input type="radio" name="q5" value="ไม่เคยมีเพศสัมพันธ์" required onchange="updateProgress()"> ไม่เคยมีเพศสัมพันธ์</label>
                    </div>
                </div>

                <div class="question">
                    <label>6. ท่านมีเพศสัมพันธ์ครั้งล่าสุดทางช่องทางใด (สามารถตอบได้มากกว่า 1 ข้อ)</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="q6[]" value="ทางทวารหนัก" onchange="updateProgress()"> ทางทวารหนัก</label>
                        <label><input type="checkbox" name="q6[]" value="ทางช่องคลอดผู้หญิง" onchange="updateProgress()"> ทางช่องคลอดผู้หญิง</label>
                        <label><input type="checkbox" name="q6[]" value="ทางช่องคลอดสาวประเภทสอง" onchange="updateProgress()"> ทางช่องคลอดสาวประเภทสอง</label>
                        <label><input type="checkbox" name="q6[]" value="ทางปาก" onchange="updateProgress()"> ทางปาก</label>
                        <label><input type="checkbox" name="q6[]" value="ไม่เคยมีเพศสัมพันธ์" onchange="updateProgress()"> ไม่เคยมีเพศสัมพันธ์</label>
                    </div>
                </div>

                <div class="question">
                    <label>7. การใช้ถุงยางอนามัย (ทั้งแบบรุก/แบบรับ) ในระยะ 3 เดือนที่ผ่านมา</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q7" value="ใช้ถุงยางทุกครั้ง" required onchange="updateProgress()"> ใช้ถุงยางทุกครั้ง</label>
                        <label><input type="radio" name="q7" value="ใช้ถุงยางเป็นบางครั้ง" required onchange="updateProgress()"> ใช้ถุงยางเป็นบางครั้ง</label>
                        <label><input type="radio" name="q7" value="ไม่เคยใช้ถุงยางเลย" required onchange="updateProgress()"> ไม่เคยใช้ถุงยางเลย</label>
                        <label><input type="radio" name="q7" value="ไม่เคยมีเพศสัมพันธ์" required onchange="updateProgress()"> ไม่เคยมีเพศสัมพันธ์</label>
                    </div>
                </div>

                <div class="question">
                    <label>8. ในช่วง 3 เดือนที่ผ่านมาท่านมีเพศสัมพันธ์แบบสอดใส่(ทั้งแบบรุก/แบบรับ) หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q8" value="มีการสอดใส่" required onchange="updateProgress()"> มีการสอดใส่</label>
                        <label><input type="radio" name="q8" value="ไม่มีการสอดใส่" required onchange="updateProgress()"> ไม่มีการสอดใส่</label>
                        <label><input type="radio" name="q8" value="ไม่แน่ใจ" required onchange="updateProgress()"> ไม่แน่ใจ</label>
                    </div>
                </div>

                <div class="question">
                    <label>9. ในระยะ 3 เดือนที่ผ่านมา ท่านเคยใช้สารเสพติด Chemsex รวมถึงระหว่างมีเพศสัมพันธ์หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q9" value="เคยใช้สารเสพติด" required onchange="updateProgress()"> เคยใช้สารเสพติด</label>
                        <label><input type="radio" name="q9" value="ไม่เคยใช้สารเสพติด" required onchange="updateProgress()"> ไม่เคยใช้สารเสพติด</label>
                        <label><input type="radio" name="q9" value="ไม่แน่ใจ" required onchange="updateProgress()"> ไม่แน่ใจ</label>
                    </div>
                </div>

                <div class="question">
                    <label>10. ท่านเคยใช้เข็มฉีดยาหรือฉีดสารเสพติด ร่วมกับผู้อื่นหรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q10" value="เคยใช้เข็มร่วมกับผู้อื่น" required onchange="updateProgress()"> เคยใช้เข็มร่วมกับผู้อื่น</label>
                        <label><input type="radio" name="q10" value="ไม่เคยใช้เข็มร่วมกับผู้อื่น" required onchange="updateProgress()"> ไม่เคยใช้เข็มร่วมกับผู้อื่น</label>
                        <label><input type="radio" name="q10" value="จำไม่ได้" required onchange="updateProgress()"> จำไม่ได้</label>
                    </div>
                </div>

                <div class="question">
                    <label>11. ในระยะ 3 เดือนที่ผ่านมา ท่านมีอาการผิดปกติ เช่นแผล ตุ่ม หนอง ที่อวัยวะเพศหรือทวารหนัก หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q11" value="เคยมี รักษาหายแล้ว" required onchange="updateProgress()"> เคยมี รักษาหายแล้ว</label>
                        <label><input type="radio" name="q11" value="มีในขณะนี้" required onchange="updateProgress()"> มีในขณะนี้</label>
                        <label><input type="radio" name="q11" value="ไม่เคยมีอาการ" required onchange="updateProgress()"> ไม่เคยมีอาการ</label>
                    </div>
                </div>

                <div class="question">
                    <label>12. ท่านรู้จัก ยา PrEP (ยาป้องกันเอชไอวี ก่อนสัมผัสเชื้อ) หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q12" value="รู้จัก ยา PrEP" required onchange="updateProgress()"> รู้จัก ยา PrEP</label>
                        <label><input type="radio" name="q12" value="ไม่รู้จัก ยา PrEP" required onchange="updateProgress()"> ไม่รู้จัก ยา PrEP</label>
                    </div>
                </div>

                <div class="question">
                    <label>13. ท่านรู้จัก ยา PEP (ยาป้องกันเอชไอวี แบบฉุกเฉิน) หรือไม่</label>
                    <div class="radio-group">
                        <label><input type="radio" name="q13" value="รู้จัก ยา PEP" required onchange="updateProgress()"> รู้จัก ยา PEP</label>
                        <label><input type="radio" name="q13" value="ไม่รู้จัก ยา PEP" required onchange="updateProgress()"> ไม่รู้จัก ยา PEP</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{-- @if(isset($productId)) --}}
                        บันทึก
                    {{-- @else
                        บันทึกและเลือกซื้อสินค้า
                    @endif --}}
                </button>
            </form>

            {{-- <div class="back-link">
                <a href="{{ route('home') }}">← กลับหน้าแรก</a>
            </div> --}}
        </div>
    </div>

@endsection

@section('script')

    <script>
        function updateProgress() {
            const totalFields = 16; // 3 personal info + 13 questions
            let answeredFields = 0;

            // Check personal info fields
            const personalFields = ['name', 'id_card', 'phone'];
            personalFields.forEach(field => {
                const input = document.querySelector(`input[name="${field}"]`);
                if (input && input.value.trim()) answeredFields++;
            });

            // Check select fields
            const selects = document.querySelectorAll('select[required]');
            selects.forEach(select => {
                if (select.value) answeredFields++;
            });

            // Check radio groups
            const radioGroups = ['q1', 'q2', 'q3', 'q4', 'q5', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13'];
            radioGroups.forEach(group => {
                const checked = document.querySelector(`input[name="${group}"]:checked`);
                if (checked) answeredFields++;
            });

            // Check checkbox group (q6)
            const checkboxes = document.querySelectorAll('input[name="q6[]"]:checked');
            if (checkboxes.length > 0) answeredFields++;

            const progress = (answeredFields / totalFields) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }
    </script>
@endsection
