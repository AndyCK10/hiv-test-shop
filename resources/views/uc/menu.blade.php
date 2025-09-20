<nav class="navbar">
    <div class="nav-container">
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-menu" id="navMenu">
            <a href="{{ route('home') }}" class="@if (in_array(request()->segment(1), [''])) active @endif">หน้าหลัก</a>
            <a href="{{ route('questionnaire.show') }}" class="@if (in_array(request()->segment(1), ['questionnaire'])) active @endif">แบบสอบถาม</a>
        </div>
        <a href="{{ route('cart.show') }}" class="cart-link">
            🛒
            @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>
    </div>
</nav>

