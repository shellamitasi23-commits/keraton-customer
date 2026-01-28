<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keraton Kasepuhan Cirebon</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="antialiased text-gray-800 flex flex-col min-h-screen">

    @include('customer.partials.navbar')

    <main class="flex-grow mt-20">
        @yield('content')
    </main>

    @include('customer.partials.footer')

 @guest
    {{-- Login Modal hanya untuk yang belum login --}}
    <dialog id="loginModal" class="p-0 rounded-xl shadow-2xl backdrop:bg-black/60 w-[400px] max-w-[90vw]">
        <div class="bg-white p-8 w-full rounded-xl relative">
            <button type="button" onclick="document.getElementById('loginModal').close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition cursor-pointer text-xl leading-none p-2">✕</button>
            
            <h3 class="text-2xl font-bold text-center mb-2 text-[#103120] pr-8">LOGIN</h3>
            <p class="text-center text-sm text-gray-600 mb-6">Masuk ke akun Anda</p>
            
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Email</label>
                    <input type="email" 
                           name="email" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base"
                           placeholder="Email Anda"
                           required>
                </div>
<br>
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Password</label>
                    <input type="password" 
                           name="password" 
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base"
                           placeholder="Password Anda"
                           required>
                </div>
                <br>

                <button type="submit" 
                        class="w-full bg-[#103120] text-white py-3 rounded-lg font-medium hover:bg-[#1a4a30] transition cursor-pointer shadow-md hover:shadow-lg active:scale-95 text-base">
                    Login
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-gray-600">
                Belum punya akun? 
                <button type="button" onclick="document.getElementById('loginModal').close(); document.getElementById('registerModal').showModal()" class="text-[#103120] hover:text-[#1a4a30] transition cursor-pointer underline">
                    Daftar
                </button>
            </p>
        </div>
    </dialog>
@endguest

    <dialog id="registerModal" class="p-0 rounded-xl shadow-2xl backdrop:bg-black/60 w-[400px] max-w-[90vw]">
        <div class="bg-white p-8 w-full relative rounded-xl">
            <button type="button" onclick="document.getElementById('registerModal').close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition cursor-pointer text-xl leading-none p-2">✕</button>
            
            <h3 class="text-2xl font-bold text-center mb-2 text-[#103120] pr-8">REGISTER</h3>
            <p class="text-center text-sm text-gray-600 mb-6">Buat akun baru Anda</p>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                @csrf
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base" placeholder="Nama Anda" required>
                </div>
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base" placeholder="Email Anda" required>
                </div>
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone" class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base" placeholder="Nomor Anda" required>
                </div>
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Password</label>
                    <input type="password" name="password" class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base" placeholder="Password Anda" required>
                </div>
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#103120] focus:border-transparent transition text-base placeholder:text-base" placeholder="Konfirmasi Password Anda" required>
                </div>
                <button type="submit" 
                        class="w-full bg-[#103120] text-white py-3 rounded-lg font-medium hover:bg-[#1a4a30] transition cursor-pointer shadow-md hover:shadow-lg active:scale-95 mt-4 text-base">
                    Register
                </button>
            </form>

            <div class="mt-6 text-center text-sm">
                <span class="text-gray-600">Sudah punya akun?</span>
                <button type="button" onclick="document.getElementById('registerModal').close(); document.getElementById('loginModal').showModal()" class="text-[#103120] hover:text-[#1a4a30] transition cursor-pointer ml-1 underline">Login</button>
            </div>
        </div>
    </dialog>

    <script>
        // Cek jika ada error session, buka modal login otomatis
        @if($errors->any())
            document.getElementById('loginModal').showModal();
        @endif

         // Auto refresh CSRF token setiap 10 menit
    setInterval(function() {
        fetch('/refresh-csrf')
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('input[name="_token"]').forEach(input => {
                    input.value = data.token;
                });
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            })
            .catch(error => console.error('CSRF refresh failed:', error));
    }, 600000); // 10 menit
    </script>

</body>
</html>