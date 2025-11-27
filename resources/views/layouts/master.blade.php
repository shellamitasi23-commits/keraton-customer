<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keraton Kasepuhan Cirebon</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="antialiased text-gray-800 flex flex-col min-h-screen">

    @include('partials.navbar')

    <main class="flex-grow mt-20">
        @yield('content')
    </main>

    @include('partials.footer')

    <dialog id="loginModal" class="bg-transparent p-0 rounded-xl shadow-2xl">
        <div class="bg-white p-8 w-[400px] relative rounded-xl border border-gray-100">
            <button onclick="document.getElementById('loginModal').close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">✕</button>
            
            <h3 class="serif text-3xl font-bold text-center mb-6 text-[#103120]">LOGIN</h3>
            
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded mb-4 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white transition" placeholder="Email Anda" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white transition" placeholder="Password Anda" required>
                </div>
                <button type="submit" class="w-full bg-[#103120] text-white py-3 rounded-lg font-bold hover:bg-green-900 transition shadow-lg transform hover:-translate-y-0.5">Login</button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-gray-500">Belum punya akun?</span>
                <button onclick="document.getElementById('loginModal').close(); document.getElementById('registerModal').showModal()" class="text-[#103120] font-bold underline ml-1">Daftar Sekarang</button>
            </div>
        </div>
    </dialog>

    <dialog id="registerModal" class="bg-transparent p-0 rounded-xl shadow-2xl">
        <div class="bg-white p-8 w-[400px] relative rounded-xl border border-gray-100">
            <button onclick="document.getElementById('registerModal').close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">✕</button>
            
            <h3 class="serif text-3xl font-bold text-center mb-6 text-[#103120]">Register</h3>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white" placeholder="Nama Anda" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white" placeholder="Email Anda" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Nomor Telephone</label>
                    <input type="text" name="phone" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white" placeholder="Nomor Anda" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-1 text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] bg-gray-50 focus:bg-white" placeholder="Password Anda" required>
                </div>
                <button type="submit" class="w-full bg-[#103120] text-white py-3 rounded-lg font-bold hover:bg-green-900 transition shadow-lg transform hover:-translate-y-0.5">Register</button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-gray-500">Sudah punya akun?</span>
                <button onclick="document.getElementById('registerModal').close(); document.getElementById('loginModal').showModal()" class="text-[#103120] font-bold underline ml-1">Login</button>
            </div>
        </div>
    </dialog>

    <script>
        // Cek jika ada error session, buka modal login otomatis
        @if($errors->any())
            document.getElementById('loginModal').showModal();
        @endif
    </script>

</body>
</html>