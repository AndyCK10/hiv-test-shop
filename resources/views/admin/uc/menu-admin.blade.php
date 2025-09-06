<div class="header">
    <h1>{{ $title_page }}</h1>
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">จัดการสินค้า</a>
        <a href="{{ route('admin.questionnaire.report') }}" class="btn btn-primary">รายงานแบบสอบถาม</a>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">จัดการแอดมิน</a>
        <a href="{{ route('admin.profile') }}" class="btn btn-primary">โปรไฟล์</a>
        <a href="{{ route('admin.logout') }}" class="btn btn-danger">ออกจากระบบ</a>
    </div>
</div>