{{-- <div class="header">
    <h1>{{ $title_page }}</h1>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary @if (in_array(request()->segment(1), [''])) active @endif">หน้าหลัก</a>
        <a href="{{ route('admin.questionnaire.report') }}" class="btn btn-primary @if (in_array(request()->segment(1), ['questionnaire'])) active @endif">รายงานแบบสอบถาม</a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary @if (in_array(request()->segment(1), ['products'])) active @endif">จัดการสินค้า</a>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-primary @if (in_array(request()->segment(1), ['admins'])) active @endif">จัดการแอดมิน</a>
        <a href="{{ route('admin.profile') }}" class="btn btn-primary @if (in_array(request()->segment(1), ['profile'])) active @endif">โปรไฟล์</a>
        <a href="{{ route('admin.logout') }}" class="btn btn-primary">ออกจากระบบ</a>
    </div>
</div> --}}
<nav class="navbar">
    <div class="nav-container">
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="header-title">{{ $title_page }}</div>
        <div class="nav-menu" id="navMenu">
            <a href="{{ route('admin.dashboard') }}" class="@if (in_array(request()->segment(2), [''])) active @endif">หน้าหลัก</a>
            <a href="{{ route('admin.questionnaire.report') }}" class="@if (in_array(request()->segment(2), ['questionnaire-report'])) active @endif">รายงานแบบสอบถาม</a>
            <a href="{{ route('admin.products.index') }}" class="@if (in_array(request()->segment(2), ['products'])) active @endif">จัดการสินค้า</a>
            <a href="{{ route('admin.admins.index') }}" class="@if (in_array(request()->segment(2), ['admins'])) active @endif">จัดการแอดมิน</a>
            <a href="{{ route('admin.profile') }}" class="@if (in_array(request()->segment(2), ['profile'])) active @endif">โปรไฟล์</a>
            <a href="{{ route('admin.logout') }}" class="">ออกจากระบบ</a>
        </div>
    </div>
</nav>
