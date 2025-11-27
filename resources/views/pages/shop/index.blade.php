@extends('layouts.master')

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
                        <div class="grid grid-cols-4 gap-2">
                            <form action="{{ route('shop.add', $product->id) }}" method="POST" class="col-span-1">
                                @csrf
                                <button type="submit" class="w-full h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 hover:border-[#103120] hover:text-[#103120] transition text-gray-400" title="Tambah ke Keranjang">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            </form>
                            
                            <form action="{{ route('shop.add', $product->id) }}" method="POST" class="col-span-3">
                                @csrf
                                <button type="submit" class="w-full h-10 bg-[#103120] text-white rounded-lg font-bold text-sm hover:bg-green-900 transition shadow-md hover:shadow-lg">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    @else
                        <button onclick="document.getElementById('loginModal').showModal()" class="w-full h-10 bg-gray-100 text-gray-500 rounded-lg font-bold text-sm hover:bg-gray-200 transition">
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