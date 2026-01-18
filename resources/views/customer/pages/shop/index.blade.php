@extends('customer.layouts.master')

@section('content')
<div class="bg-gray-50 py-12 text-center border-b border-gray-200">
    <h1 class="serif text-4xl font-bold text-[#103120] mb-2">Merchandise Keraton</h1>
    <p class="text-gray-500">Dapatkan koleksi eksklusif dan souvenir khas Cirebon</p>
</div>

<div class="max-w-7xl mx-auto px-6 py-12">
    
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-8 text-center font-bold shadow-sm">
             {{ session('success') }} 
            <a href="{{ route('shop.cart') }}" class="underline ml-2 hover:text-green-900">Lihat Keranjang</a>
        </div>
    @endif
{{-- Alert Success/Error (Taruh di atas produk list) --}}
@if(session('success'))
    <div class="fixed top-24 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
        ✓ {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('.animate-fade-in').style.display = 'none';
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div class="fixed top-24 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        ✗ {{ session('error') }}
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('.bg-red-500').style.display = 'none';
        }, 3000);
    </script>
@endif
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        
        @foreach($products as $product)
        <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 flex flex-col">
            
            <div class="relative h-64 bg-gray-200 overflow-hidden">
                <img src="{{ asset('images/products/' . $product->image) }}" 
                     class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                     alt="{{ $product->name }}"
                     onerror="this.src='https://via.placeholder.com/300?text=No+Image'">
                
                <span class="absolute top-3 left-3 bg-white/90 text-[#103120] text-xs font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wider">
                    {{ $product->category }}
                </span>
            </div>

            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-bold text-lg text-[#103120] mb-1 group-hover:text-[#E89020] transition">{{ $product->name }}</h3>
                
                <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed">
                    {{ $product->description }}
                </p>
                
                <div class="mt-auto pt-4 border-t border-dashed border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs text-gray-400">Harga</span>
                        <span class="font-bold text-lg text-[#103120]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>

                  @auth
    {{-- Form Add to Cart untuk User yang Sudah Login --}}
    <form action="{{ route('shop.add', $product->id) }}" method="POST">
        @csrf
        <div class="flex items-center gap-2 mb-3">
            <label class="text-sm font-semibold">Jumlah:</label>
            <input type="number" 
                   name="quantity" 
                   value="1" 
                   min="1" 
                   max="{{ $product->stock }}"
                   class="w-20 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#103120]"
                   required>
        </div>
        
        <button type="submit" 
                class="w-full bg-[#103120] text-white py-3 rounded-lg font-semibold hover:bg-[#1a4a30] transition">
            <i class="mdi mdi-cart-plus mr-2"></i>
            Tambah ke Keranjang
        </button>
    </form>
@else
    {{-- Tombol Login untuk Guest --}}
    <button onclick="document.getElementById('loginModal').showModal()" 
            class="w-full bg-[#103120] text-white py-3 rounded-lg font-semibold hover:bg-[#1a4a30] transition">
        <i class="mdi mdi-login mr-2"></i>
        Login untuk Membeli
    </button>
@endauth
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection