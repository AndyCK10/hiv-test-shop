<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
    <title>
        
    </title>
    <meta charset="utf-8" />
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
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .nav-links { margin-bottom: 20px; }
        .nav-links a { color: #3498db; text-decoration: none; margin-right: 15px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
        .stat-number { font-size: 36px; font-weight: bold; color: #3498db; }
        .orders-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #34495e; color: white; }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status.pending { background: #f39c12; color: white; }
        .status.confirmed { background: #27ae60; color: white; }
        .status.completed { background: #3498db; color: white; }
        .free-badge { background: #27ae60; color: white; padding: 3px 8px; border-radius: 10px; font-size: 11px; }
        /* .btn { padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-danger { background: #e74c3c; color: white; } */
        .btn { 
            font-family: var(--var-font-family);
            padding: 12px 25px; 
            margin: 10px 5px; 
            border: none; 
            border-radius: 25px; 
            cursor: pointer; 
            font-size: 16px; 
            text-decoration: none; 
            display: inline-block; 
            text-align: center; 
        }
        .btn-primary { background: #4acb95; color: white; }
        .btn-secondary { background: #fbea61; color: white; }
        .btn-success { background: #21c7d3; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn:hover { opacity: 0.9; color: white; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #2c3e50; }
        input, textarea, select { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus, textarea:focus, select:focus { border-color: #3498db; outline: none; }
        h2 { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .form-container { padding: 20px; }
            .btn { width: 100%; margin: 10px 0; }
        }
        @media (max-width: 480px) {
            .header h1 { font-size: 24px; }
            input, textarea, select { font-size: 16px; }
            .current-image { max-width: 150px; }
        }
    </style>
</head>

<body>
    <!-- Page -->
    @yield('css')
    @yield('content')
    <!-- End of Page -->
    @yield('script')
</body>

</html>
