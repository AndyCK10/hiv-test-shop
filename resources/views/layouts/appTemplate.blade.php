<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        HIV Self Test Shop
    </title>
    <meta charset="utf-8" />
    <meta content="images/app/logo.png" property="og:image" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link href="images/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="images/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="images/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('images/app/favicon-32x32.png') }}" sizes="32x32" rel="shortcut icon" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" /> --}}
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --var-font-family: 'Kanit', Arial, sans-serif; background: #f8f9fa;
        }
        body { font-family: var(--var-font-family); background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .navbar {
            /* background: #2c3e50;  */
            padding: 15px 0;
            /* margin-bottom: 20px;  */
        }
        .nav-container { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-menu { display: flex; gap: 30px; }
        .nav-menu a { color: #2c3e50; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .nav-menu a:hover { color: #21c7d3; }
        .nav-menu a.active { color: #21c7d3; }
        .hamburger { display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: #777; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-4px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-7px, -8px); }
        .cart-link {
            /* background: #3498db;  */
            color: white;
            /* padding: 10px 20px;  */
            /* border-radius: 20px;  */
            text-decoration: none;
            position: relative;
        }
        .cart-link:hover {
            /* background: #3498db;  */
        }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #ff0000; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center; }
        .header { text-align: center; margin-bottom: 1rem; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .products { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .product { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .product-image { width: 100%; max-height: 270px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .no-image { width: 100%; height: 270px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 15px; color: #666; }
        .product h3 { color: #2c3e50; margin-bottom: 15px; font-size: 20px; }
        .product h3 a { color: #2c3e50; text-decoration: none; }
        .product h3 a:hover { color: #21c7d3; }
        /* .product h3 a:hover { color: #fbea61; } */
        .short-desc { color: #666; margin-bottom: 10px; }
        .price {
            font-size: 18px;
            color: #ff0000;
            font-weight: bold;
            margin: 0.25rem 0;
        }
        .free-badge {
            color: #21c7d3;
            /* color: #4acb95; */
            /* background: #fbea61;
            padding: 5px 15px;
            border-radius: 20px;  */
            font-size: 14px;
            margin-left: 10px;
        }
        button {font-family: var(--var-font-family);}
        .btn {
            font-family: var(--var-font-family);
            padding: 12px 25px;
            /* margin: 10px 5px; */
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary { background: #21c7d3; color: white; }
        .btn-secondary { background: #ff7adb /*#fbea61 */; color: white; }
        .btn-success { background: #4acb95; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); color: white; }
        .description { color: #666; margin: 15px 0; line-height: 1.6; }
        .shipping { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin: 20px 0; }
        a { color: #2c3e50; text-decoration: none}
        a:hover{ color: #21c7d3;}
        input, textarea, select {
            font-family: var(--var-font-family);
            /* width: 100%;  */
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        @media screen and (max-width: 768px) {
            .nav-container { position: relative; }
            .hamburger { display: flex; }
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #e9ecef; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .container { padding: 10px; }
            .header { padding: 1rem; }
            .products { grid-template-columns: 1fr; gap: 20px; }
            .product { padding: 20px; }
            .btn { width: 100%; margin: 5px 0; }
        }
        @media screen and (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .cart-link {
                /* padding: 8px 15px;  */
                font-size: 20px;
            }
            .header h1 { font-size: 24px; }
            .product h3 { font-size: 20px; }
            .price { font-size: 24px; }
        }
    </style>
</head>

<body>
    <!-- Page -->
    @yield('css')
    @yield('content')
    @yield('script')

    <script>
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.getElementById('navMenu');

            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        }

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.hamburger').classList.remove('active');
                document.getElementById('navMenu').classList.remove('active');
            });
        });
    </script>
</body>



</html>
