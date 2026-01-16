@extends('customer.layouts.master')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Keranjang Belanja</h1>
        <span class="text-gray-500">{{ $carts->count() }} Item</span>
    </div>

    @if($carts->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700">PRODUK</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($carts as $cart)
                        <div class="p-6 flex items-start justify-between gap-4">
                            <!-- Product Info -->
                            <div class="flex items-start gap-4 flex-1">
                               <div class="w-12 h-12 rounded-md overflow-hidden bg-gray-100 shrink-0">
                                    <img src="{{ asset('images/products/' . $cart->product->image) }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://via.placeholder.com/80?text=No+Image'"
                                         alt="{{ $cart->product->name }}">
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 mb-2">{{ $cart->product->name }}</h3>
                                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Quantity Controls & Delete -->
                            <div class="flex flex-col items-end gap-3">
                                <!-- Quantity Control -->
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="decrease">
                                        <button type="submit" class="px-3 py-2 hover:bg-gray-100 transition">
                                            <span class="text-xl text-gray-600">−</span>
                                        </button>
                                    </form>
                                    
                                    <span class="px-4 py-2 min-w-[50px] text-center font-medium">{{ $cart->quantity }}</span>
                                    
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="increase">
                                        <button type="submit" class="px-3 py-2 hover:bg-gray-100 transition">
                                            <span class="text-xl text-gray-600">+</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('shop.delete', $cart->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm flex items-center gap-1 hover:text-red-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Pesanan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden sticky top-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700">Ringkasan Pesanan</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Item ({{ $carts->sum('quantity') }})</span>
                            <span>{{ $carts->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Estimasi Berat</span>
                            <span>{{ $carts->sum('quantity') * 350 }}g</span>
                        </div>
                        
                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total Harga</span>
                            <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <button onclick="window.location.href='{{ route('shop.checkout') }}'" 
                                class="w-full bg-[#103120] text-white py-3 rounded-lg font-semibold hover:bg-[#0a2416] transition">
                            Checkout Sekarang
                        </button>
                        
                        <button onclick="window.location.href='{{ route('shop.index') }}'" 
                                class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Lanjut Belanja
                        </button>
                        
                        <p class="text-xs text-gray-500 text-center mt-4">
                            Ongkos kirim akan dihitung di halaman selanjutnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-lg border border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <p class="text-gray-500 mb-4 text-lg">Keranjang belanja Anda kosong</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-[#103120] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#0a2416] transition">
                Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection