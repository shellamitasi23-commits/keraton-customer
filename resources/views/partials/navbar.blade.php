<nav class="bg-[#103120] text-white py-4 px-6 fixed w-full top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain"> 
        </a>

        <div class="hidden md:flex gap-8 text-sm font-medium uppercase tracking-wide">
            <a href="{{ route('home') }}" class="hover:text-yellow-400 {{ request()->routeIs('home') ? 'text-yellow-400 border-b-2 border-yellow-400' : '' }}">Home</a>
            <a href="{{ route('tiket.index') }}" class="hover:text-yellow-400 {{ request()->routeIs('tiket.*') ? 'text-yellow-400 border-b-2 border-yellow-400' : '' }}">Tiket</a>
            <a href="{{ route('shop.index') }}" class="hover:text-yellow-400 {{ request()->routeIs('shop.*') ? 'text-yellow-400 border-b-2 border-yellow-400' : '' }}">Shop</a>
            <a href="{{ route('museum') }}" class="hover:text-yellow-400 {{ request()->routeIs('museum') ? 'text-yellow-400 border-b-2 border-yellow-400' : '' }}">Museum</a>
        </div>

        <div class="flex items-center gap-6">
            @auth
                <a href="{{ route('profile.index') }}" class="flex items-center gap-2 hover:text-yellow-400 transition group">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-medium text-sm">{{ Auth::user()->name }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium hover:text-red-400 transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <button onclick="document.getElementById('loginModal').showModal()" class="bg-white text-[#103120] px-5 py-2 rounded font-semibold text-sm hover:bg-gray-200 transition">
                    Login
                </button>
                <button onclick="document.getElementById('registerModal').showModal()" class="border border-white px-5 py-2 rounded font-semibold text-sm hover:bg-white hover:text-[#103120] transition">
                    Register
                </button>
            @endauth
        </div>
    </div>
</nav>