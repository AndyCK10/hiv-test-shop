<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    <title>

    </title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="follow, index" name="robots" />
    <meta content="images/app/logo.png" property="og:image" />
    <link href="images/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="images/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="images/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="{{ asset('images/app/favicon-32x32.png') }}" sizes="32x32" rel="shortcut icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    {{-- @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js']) --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --var-font-family: 'Inter', 'Kanit', Arial, sans-serif; background: #f8f9fa;
        }
        body { font-family: var(--var-font-family); background: #f8f9fa; }
        .header { background: #2c3e50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { /*max-width: 1200px;*/ margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #009688; text-decoration: none; margin-right: 15px; }

        .navbar {
            /* background: #2c3e50; */
            /* background: #eee; */
            border-bottom: 1px solid #d0d0d0;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        .nav-container { /*max-width: 1200px;*/ margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .nav-menu { display: flex; gap: 30px; }
        .nav-menu a { color: #607D8B; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .nav-menu a:hover { color: #009688; }
        .nav-menu a.active { color: #009688; }
        .hamburger { display: none; flex-direction: column; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: #009688; margin: 3px 0; transition: 0.3s; }
        .hamburger.active span:nth-child(1) { transform: rotate(-45deg) translate(-4px, 6px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(45deg) translate(-7px, -8px); }
        .header-title{ color: #009688; text-decoration: none; font-weight: 500; font-size: 2em;}

        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 36px; font-weight: bold; /*color: #3498db;*/ color: #009688;}
        .orders-table { background: white; border-radius: 10px; overflow-x: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #2c3e50; }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 12px;}
        .status.pending { background: #f39c12; color: white; }
        .status.confirmed { background: #27ae60; color: white; }
        .status.completed { background: #3498db; color: white; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 11px; }
        /* .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #ff0000; color: white; } */
        button {font-family: var(--var-font-family);}
        .btn {
            font-family: var(--var-font-family);
            padding: 8px 20px;
            /* margin: 10px 5px; */
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary { background: #009688; color: white; }
        .btn-secondary { background: #fbea61; color: white; }
        .btn-success { background: #21c7d3; color: white; }
        .btn-danger { background: #ff0000; color: white; }
        .btn-dark { background: #6c757d; color: white; }
        .btn:hover { opacity: 0.9; color: white; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { font-family: var(--var-font-family); width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        h2 { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        .success { color: #27ae60 }
        .w-5 {
            width: 24px;
        }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .nav-container { position: relative; }
            .hamburger { display: flex;}
            .nav-menu { position: absolute; top: 100%; left: 0; right: 0; background: #eee; flex-direction: column; padding: 20px; gap: 15px; transform: translateY(-100%); opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 1000; }
            .nav-menu.active { transform: translateY(0); opacity: 1; visibility: visible; }
            .form-container { padding: 20px; }
            .header { padding: 1rem; }
            .btn { width: 100%; margin: 10px 0; }
        }
        @media (max-width: 480px) {
            .nav-menu a { font-size: 14px; }
            .header h1 { font-size: 24px; }
            input, textarea, select { font-size: 16px; }
            .current-image { max-width: 150px; }
        }

        /* Pagination styles */
        .pagination { display: flex; justify-content: center; gap: 5px; margin: 20px 0; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #333; border-radius: 4px; }
        .pagination a:hover { background: #f8f9fa; }
        .pagination .active span { background: #009688; color: white; border-color: #009688; }
        .pagination .disabled span { color: #ccc; }

        @media (max-width: 768px) {
            .pagination { flex-wrap: wrap; gap: 3px; }
            .pagination a, .pagination span { padding: 6px 10px; font-size: 14px; }
        }
    </style>
</head>

<body>
    <!-- Page -->
    @yield('css')
    @yield('content')
    <!-- End of Page -->
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
