<nav class="navbar">
    <div class="nav-container">
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="nav-menu" id="navMenu">
            <a href="{{ route('home') }}" class="active">หน้าหลัก</a>
            <a href="{{ route('questionnaire.show') }}">แบบสอบถาม</a>
        </div>
        <a href="{{ route('cart.show') }}" class="cart-link">
            🛒
            @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>
    </div>
</nav>
{{-- <script>
    function toggleMenu() {
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.getElementById('navMenu');
        
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    }

    $(document).ready(function() {
        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.hamburger').classList.remove('active');
                document.getElementById('navMenu').classList.remove('active');
            });
        });

    });
</script> --}}