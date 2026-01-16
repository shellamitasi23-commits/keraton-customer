<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Keraton Cirebon</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <style>
        .auth-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #000; }
        .auth-card { background: #191c24; padding: 2rem; border-radius: 10px; width: 100%; max-width: 400px; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h3 class="text-center mb-4">Login Keraton</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control text-white" required placeholder="Masukkan username">
                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control text-white" required placeholder="Masukkan password">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-block">Masuk Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>