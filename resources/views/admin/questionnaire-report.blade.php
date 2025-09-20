@extends('layouts.authTemplate')

@section('css')
    <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #3498db; text-decoration: none; margin-right: 15px; } */
        .report-container { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-number { font-size: 32px; font-weight: bold; color: #2c3e50; }
        .stat-label { color: #666; margin-top: 5px; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; color: #2c3e50; }
        /* .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin: 2px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #ff0000; color: white; }
        .logout { color: white; text-decoration: none; padding: 10px 20px; background: #ff0000; border-radius: 5px; } */
        .answers { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .answers:hover { white-space: normal; overflow: visible; }

        .question-body {margin-bottom: 0.5rem; overflow-y: scroll; height: 50vh;}
        .question-capsule {margin-bottom: 0.5rem;}
        .question-capsule .ques {
            color: #666;
            font-weight: 500;
        }
        .question-capsule .ans {
            color: #27ae60;
            padding-left: 1rem;
        }

        @media (max-width: 768px) {
            .container { padding: 10px; }
            .report-container { padding: 20px; }
            .stats { grid-template-columns: 1fr; }
            table { font-size: 14px; }
            th, td { padding: 8px; }
        }
    </style>
@endsection

@section('content')
    <!-- Menu -->
    @include('admin.uc.menu-admin', [
        'title_page' =>  'รายงานแบบสอบถาม'
    ])

    <div class="container">
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">แดชบอร์ด</a> > รายงานแบบสอบถาม
        </div>

        <div class="report-container">
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number">{{ $questionnaires->count() }}</div>
                    <div class="stat-label">แบบสอบถามทั้งหมด</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $questionnaires->where('created_at', '>=', Carbon::now()->subDays(7))->count() }}</div>
                    <div class="stat-label">7 วันที่ผ่านมา</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $questionnaires->where('created_at', '>=', Carbon::now()->subDays(30))->count() }}</div>
                    <div class="stat-label">30 วันที่ผ่านมา</div>
                </div>
            </div>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">ค้นหา (ชื่อ/เบอร์)</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="กรอกชื่อหรือเบอร์โทร" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
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
                        <a href="{{ route('admin.questionnaire.report') }}" class="btn" style="background: #6c757d; color: white;">ล้าง</a>
                    </div>
                </form>
            </div>

            <h3>รายละเอียดแบบสอบถาม</h3>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>ชื่อ-สกุล</th>
                            <th>เบอร์โทร</th>
                            <th>สินค้า</th>
                            <th>คำตอบ</th>
                            <th>การดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questionnaires as $questionnaire)
                        <tr>
                            <td>{{ $questionnaire->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $questionnaire->order->name ?? '-' }}</td>
                            <td>{{ $questionnaire->order->phone ?? '-' }}</td>
                            <td>
                                @if($questionnaire->order && $questionnaire->order->product)
                                    {{ $questionnaire->order->product->name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="answers" title="{{ json_encode($questionnaire->answers, JSON_UNESCAPED_UNICODE) }}">
                                {{ Str::limit(json_encode($questionnaire->answers, JSON_UNESCAPED_UNICODE), 50) }}
                            </td>
                            <td>
                                <a href="#" onclick="showAnswers({{ $questionnaire->id }})" class="btn btn-primary">ดูคำตอบ</a>
                                @if($questionnaire->order)
                                    <a href="{{ route('admin.order.show', $questionnaire->order->id) }}" class="btn btn-success">ดูคำสั่งซื้อ</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #666;">ยังไม่มีข้อมูลแบบสอบถาม</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for showing answers -->
    <div id="answerModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 1rem; border-radius: 10px; max-width: 600px; max-height: 80vh; overflow-y: visible;">
            <h3>คำตอบแบบสอบถาม</h3>
            <div id="answerContent"></div>
            <div style="text-align: center">
                <button onclick="closeModal()" class="btn btn-primary" style="width: 150px;">ปิด</button>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        const questionnaires = @json($questionnaires);

        function showAnswers(id) {

            const questionnaire = questionnaires.find(q => q.id === id);

            if (!questionnaire) return;

            // const answers = JSON.parse(questionnaire.answers);
            const answers = questionnaire.answers;
            // console.log(answers);

            // let content = `
            //     <p><strong>ชื่อ:</strong> ${questionnaire.order ? questionnaire.order.name : '-'}</p>
            //     <p><strong>เลขบัตรประชาชน:</strong> ${questionnaire.order ? questionnaire.order.id_card : '-'}</p>
            //     <p><strong>เบอร์โทร:</strong> ${questionnaire.order ? questionnaire.order.phone : '-'}</p>
            //     <hr style="margin: 15px 0;">
            // `;
            let content = `
                <p><strong>ชื่อ:</strong> ${questionnaire ? questionnaire.name : '-'}</p>
                <p><strong>เลขบัตรประชาชน:</strong> ${questionnaire ? questionnaire.id_card : '-'}</p>
                <p><strong>เบอร์โทร:</strong> ${questionnaire ? questionnaire.phone : '-'}</p>
                <hr style="margin: 15px 0;">
                <div class="question-body">
            `;

            const questions = {
                'q1': 'ท่านนิยามตนเองว่าเป็นกลุ่มประชากรใด',
                'q2': 'ท่านเคยได้รับสิ่งของหรือเงิน เพื่อนำไปสู่การมีเพศสัมพันธ์หรือไม่',
                'q3': 'ผลการตรวจเอชไอวี ครั้งล่าสุด',
                'q4': 'เพศสัมพันธ์กับคู่นอน ในระยะ 3 เดือนที่ผ่านมา',
                'q5': 'บทบาททางเพศ',
                'q6': 'ท่านมีเพศสัมพันธ์ครั้งล่าสุดทางช่องทางใด',
                'q7': 'การใช้ถุงยางอนามัย ในระยะ 3 เดือนที่ผ่านมา',
                'q8': 'ในช่วง 3 เดือนที่ผ่านมาท่านมีเพศสัมพันธ์แบบสอดใส่หรือไม่',
                'q9': 'ในระยะ 3 เดือนที่ผ่านมา ท่านเคยใช้สารเสพติด Chemsex หรือไม่',
                'q10': 'ท่านเคยใช้เข็มฉีดยาหรือฉีดสารเสพติด ร่วมกับผู้อื่นหรือไม่',
                'q11': 'ในระยะ 3 เดือนที่ผ่านมา ท่านมีอาการผิดปกติที่อวัยวะเพศหรือทวารหนักหรือไม่',
                'q12': 'ท่านรู้จัก ยา PrEP หรือไม่',
                'q13': 'ท่านรู้จัก ยา PEP หรือไม่'
            };

            let i = 1
            Object.keys(questions).forEach(key => {
                if (answers[key]) {
                    content += `<div class="question-capsule"><div class="ques">${i++} ${questions[key]}:</div>
                        <div class="ans">${Array.isArray(answers[key]) ? answers[key].join(', ') : answers[key]}</div></div>`;
                }
            });
            content += `</div>`;

            document.getElementById('answerContent').innerHTML = content;
            document.getElementById('answerModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('answerModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('answerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endsection


