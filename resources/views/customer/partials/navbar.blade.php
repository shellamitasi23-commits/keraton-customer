<nav class="bg-[#103120] text-white py-4 px-6 fixed w-full top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ route('customer.home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain"> 
        </a>

        <div class="hidden md:flex gap-8 text-sm font-medium uppercase tracking-wide">
            <a href="{{ route('customer.home') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('customer.home') ? 'text-yellow-400 border-b-2 border-yellow-400 pb-1' : '' }}">
                Home
            </a>
            <a href="{{ route('tiket.index') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('tiket.*') ? 'text-yellow-400 border-b-2 border-yellow-400 pb-1' : '' }}">
                Tiket
            </a>
            <a href="{{ route('shop.index') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('shop.*') ? 'text-yellow-400 border-b-2 border-yellow-400 pb-1' : '' }}">
                Shop
            </a>
            <a href="{{ route('museum') }}" class="hover:text-yellow-400 transition {{ request()->routeIs('museum') ? 'text-yellow-400 border-b-2 border-yellow-400 pb-1' : '' }}">
                Museum
            </a>
        </div>

        <div class="flex items-center gap-4">
           @auth
                <a href="{{ route('shop.cart') }}" 
                   class="relative text-white hover:text-yellow-400 transition group" 
                   title="Lihat Keranjang">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    @php
                        // Hitung cart count otomatis jika belum di-pass dari controller
                        $cartCount = $cartCount ?? \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                    @endphp

                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-[#103120] animate-pulse">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('profile.index') }}" 
                   class="flex items-center gap-2 hover:opacity-90 transition group bg-white/10 rounded-full pl-1 pr-3 py-1">
                    
                    <div class="relative">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                 class="h-8 w-8 rounded-full object-cover border-2 border-yellow-400" 
                                 alt="Avatar">
                        @else
                            <div class="h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center border-2 border-yellow-400">
                                <span class="text-[#103120] font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <span class="text-yellow-400 text-lg ml-1">●</span>
                    </div>
                    
                    <span class="font-semibold text-sm text-white group-hover:text-yellow-400 transition">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                        <span class="text-[10px] text-gray-300 hidden lg:block">
                            Lihat Profil
                        </span>
                    </div>
                </a>

                {{-- Logout Button --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    <button type="submit" 
                            class="text-white hover:text-red-400 transition p-2 rounded-full hover:bg-white/10 cursor-pointer" 
                            title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            @else
                <button onclick="document.getElementById('loginModal').showModal()" 
                        class="bg-white text-[#103120] px-5 py-2 rounded-lg font-semibold text-sm hover:bg-gray-200 transition">
                    Login
                </button>
                <button onclick="document.getElementById('registerModal').showModal()" 
                        class="border-2 border-white px-5 py-2 rounded-lg font-semibold text-sm hover:bg-white hover:text-[#103120] transition">
                    Register
                </button>
            @endauth
        </div>
    </div>
</nav>

<div class="h-20"></div>