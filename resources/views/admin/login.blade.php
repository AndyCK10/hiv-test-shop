<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --var-font-family: 'Inter', 'Kanit', Arial, sans-serif; background: #f8f9fa;
        }
        body { font-family: var(--var-font-family); background: #2c3e50; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 8px 25px rgba(0,0,0,0.3); width: 400px; }
        h2 { text-align: center; margin-bottom: 30px; color: #2c3e50; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #34495e; }
        input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 16px; }
        input:focus { border-color: #3498db; outline: none; }
        .btn { 
            width: 100%;
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
        .btn:hover { opacity: 0.9; color: white; }
        .error { background: #e74c3c; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 Admin Login</h2>
        
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>

        <div class="back-link">
            <a href="{{ route('admin.forgot-password') }}">ลืมรหัสผ่าน?</a><br>
            <a href="{{ route('home') }}">กลับหน้าแรก</a>
        </div>
    </div>
</body>
</html>