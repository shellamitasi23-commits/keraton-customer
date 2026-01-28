@extends('customer.layouts.master')

@section('content')
<div class="bg-gray-50 py-12 text-center border-b border-gray-200">
    <h1 class="serif text-3xl sm:text-4xl font-bold text-[#103120] mb-2">Merchandise Keraton</h1>
    <p class="text-sm sm:text-base text-gray-500">Dapatkan koleksi eksklusif dan souvenir khas Cirebon</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    
    @if(session('success'))
        <div id="successAlert" class="fixed top-24 right-4 bg-green-500 text-white px-4 sm:px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 text-sm sm:text-base">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
            <a href="{{ route('shop.cart') }}" class="underline ml-2 hover:text-green-100">Lihat Keranjang</a>
        </div>
    @endif

    @if(session('error'))
        <div id="errorAlert" class="fixed top-24 right-4 bg-red-500 text-white px-4 sm:px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 text-sm sm:text-base">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="text-center py-20">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h3 class="mt-4 text-lg sm:text-xl font-semibold text-gray-900">Belum Ada Produk</h3>
            <p class="mt-2 text-sm sm:text-base text-gray-500">Produk sedang dalam proses penambahan. Silakan cek kembali nanti.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            @foreach($products as $product)
            <div class="group bg-white border border-gray-100 rounded-lg sm:rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                
                <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                    @if($product->image && file_exists(public_path('storage/' . $product->image)))
                        {{-- Gambar Asli --}}
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             alt="{{ $product->name }}"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                        {{-- Fallback jika gambar error --}}
                            <div class="text-center p-6">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-gray-400 font-medium">{{ $product->name }}</p>
                            </div>
                        </div>
                    @else
                        {{-- Placeholder Jika Tidak Ada Gambar --}}
                            <div class="text-center p-6">
                                <svg class="w-20 h-20 mx-auto text-[#103120]/30 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-gray-500 font-medium px-4">{{ Str::limit($product->name, 30) }}</p>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Badge Overlay Container --}}
                    <div class="absolute top-0 left-0 right-0 p-3 flex items-start justify-between">
                        {{-- Stock Status Badge (Kiri) --}}
                        <span class="inline-flex items-center
                            @elseif($product->stock > 0) bg-yellow-500
                            @else bg-red-500
                            @endif
                            text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                            @if($product->stock > 10)
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Tersedia
                            @elseif($product->stock > 0)
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Terbatas
                            @else
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                Habis
                            @endif
                        </span>

                        {{-- Stock Count Badge (Kanan) - Hanya tampil jika stok < 10 --}}
                        @if($product->stock > 0 && $product->stock < 10)
                            <span class="inline-flex items-center bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                                </svg>
                                {{ $product->stock }} pcs
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="p-4 sm:p-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-base sm:text-lg text-[#103120] mb-2 group-hover:text-[#E89020] transition-colors line-clamp-2 min-h-[3.5rem]">
                        {{ $product->name }}
                    </h3>
                    
                    <p class="text-xs sm:text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed flex-grow">
                        {{ $product->description }}
                    </p>
                    
                    {{-- Price & Action --}}
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs text-gray-400 uppercase tracking-wide">Harga</span>
                            <div class="text-right">
                                <span class="font-bold text-lg sm:text-xl text-[#103120] block">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
@auth
    <form action="{{ route('shop.cart.add', $product->id) }}" method="POST">
        @csrf
        
        <div class="flex items-center justify-between mb-4">
            <label class="text-sm font-bold text-gray-700">Jumlah:</label>
            <div class="flex flex-col items-end">
                <input type="number" 
                       name="quantity" 
                       value="1" 
                       min="1" 
                       max="{{ $product->stock }}"
                       class="w-20 py-1.5 px-2 border border-gray-300 rounded-lg text-center font-bold text-gray-700 focus:outline-none focus:border-[#103120] focus:ring-1 focus:ring-[#103120] transition"
                       {{ $product->stock < 1 ? 'disabled' : 'required' }}>
                <span class="text-[10px] text-gray-400 mt-1">Stok: {{ $product->stock }}</span>
            </div>
        </div>

        {{-- Area Tombol Action --}}
        @if($product->stock > 0)
            <div class="flex flex-col gap-3">
                
                <button type="submit" name="type" value="buy_now"
                        class="w-full bg-[#103120] text-white py-4 rounded-xl font-bold shadow-md hover:bg-[#0b2416] hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                    <span>Beli Langsung</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>

                <button type="submit" name="type" value="add"
                        class="w-full bg-white border border-[#103120] text-[#103120] py-3.5 rounded-xl font-bold hover:bg-gray-50 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>+ Keranjang</span>
                </button>

            </div>
        @else
            {{-- Tombol Stok Habis --}}
                    class="w-full bg-gray-100 text-gray-400 py-3.5 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2 border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <span>Stok Habis</span>
            </button>
        @endif
    </form>
@else
    {{-- Tombol Login untuk Guest --}}
        <button onclick="document.getElementById('loginModal').showModal()" 
                class="w-full bg-[#103120] text-white py-3.5 rounded-xl font-bold shadow-md hover:bg-[#0b2416] transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span>Login untuk Membeli</span>
        </button>
    </div>
@endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Auto-hide Alert Script --}}
@if(session('success') || session('error'))
<script>
    setTimeout(function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if(successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }
        
        if(errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 3000);
</script>
@endif

@endsection