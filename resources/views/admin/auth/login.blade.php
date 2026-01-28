<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Keraton Kasepuhan Cirebon</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: #103120;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: #C8F05A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 35px;
            color: #103120;
        }

        .login-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.8;
            margin: 0;
        }

        .login-body {
            padding: 35px 30px;
        }

        .alert {
            background: #fee;
            border-left: 4px solid #e33;
            color: #c00;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: #103120;
            background: #fafafa;
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        .error-text {
            color: #e33;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin: 0;
        }

        .btn-login {
            width: 100%;
            background: #103120;
            color: white;
            padding: 13px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #1a4a30;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 49, 32, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            font-size: 12px;
            color: #666;
        }

        @media (max-width: 480px) {
            .login-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Admin Portal</h2>
            <p>Keraton Kasepuhan Cirebon</p>
        </div>

        <div class="login-body">
            @if(session('error'))
                <div class="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username"
                            name="username" 
                            value="{{ old('username') }}" 
                            placeholder="Masukkan username"
                            required 
                            autofocus>
                        <i class="mdi mdi-account input-icon"></i>
                    </div>
                    @error('username')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Masukkan password"
                            required>
                        <i class="mdi mdi-lock input-icon"></i>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Masuk
                </button>
            </form>
        </div>

        <div class="login-footer">
            &copy; 2026 Keraton Kasepuhan Cirebon - Admin Panel
        </div>
    </div>
</body>
</html> 