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
                                <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                                    @if($cart->product->image)
                                        <img src="{{ asset('storage/' . $cart->product->image) }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.src='https://via.placeholder.com/80?text=No+Image'"
                                             alt="{{ $cart->product->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/80?text=No+Image" 
                                             class="w-full h-full object-cover"
                                             alt="{{ $cart->product->name }}">
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 mb-2">{{ $cart->product->name }}</h3>
                                    <p class="text-lg font-bold text-[#E89020]">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Stok: {{ $cart->product->stock }}</p>
                                </div>
                            </div>

                            <!-- Quantity Controls & Delete -->
                            <div class="flex flex-col items-end gap-3">
                                <!-- Quantity Control -->
                                <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                                    <form action="{{ route('shop.cart.update', $cart->id) }}" method="POST" class="inline">
                                        @csrf 
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ max(1, $cart->quantity - 1) }}">
                                        <button type="submit" 
                                                class="px-4 py-2 hover:bg-gray-100 transition"
                                                {{ $cart->quantity <= 1 ? 'disabled' : '' }}>
                                            <span class="text-xl text-gray-600 font-bold">−</span>
                                        </button>
                                    </form>
                                    
                                    <span class="px-6 py-2 min-w-[60px] text-center font-bold text-lg">{{ $cart->quantity }}</span>
                                    
                                    <form action="{{ route('shop.cart.update', $cart->id) }}" method="POST" class="inline">
                                        @csrf 
                                        @method('PUT')
                                        <input type="hidden" name="quantity" value="{{ $cart->quantity + 1 }}">
                                        <button type="submit" 
                                                class="px-4 py-2 hover:bg-gray-100 transition"
                                                {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}>
                                            <span class="text-xl text-gray-600 font-bold">+</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Subtotal -->
                                <p class="text-sm text-gray-600">
                                    Subtotal: <span class="font-bold text-gray-900">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</span>
                                </p>

                                <!-- Delete Button -->
                                <form action="{{ route('shop.cart.delete', $cart->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 text-sm flex items-center gap-1 hover:text-red-700 transition font-medium"
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')">
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
                    <div class="px-6 py-4 border-b border-gray-200 bg-[#103120]">
                        <h2 class="text-lg font-semibold text-white">Ringkasan Pesanan</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Item</span>
                            <span class="font-semibold">{{ $carts->sum('quantity') }} pcs</span>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Jumlah Produk</span>
                            <span class="font-semibold">{{ $carts->count() }} jenis</span>
                        </div>
                        
                        <hr class="border-gray-200 my-3">
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-base font-semibold text-gray-800">Subtotal</span>
                            <span class="text-2xl font-bold text-[#E89020]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <p class="text-xs text-gray-500 bg-blue-50 p-3 rounded-lg border border-blue-100">
                            💡 Ongkos kirir <strong>Rp {{ number_format(15000, 0, ',', '.') }}</strong> akan ditambahkan di halaman checkout
                        </p>
                        
                        <button onclick="window.location.href='{{ route('shop.checkout') }}'" 
                                class="w-full bg-[#103120] text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300 cursor-pointer">
                            Lanjut ke Checkout
                        </button>
                        
                        <button onclick="window.location.href='{{ route('shop.index') }}'" 
                                class="w-full border-2 border-[#103120] text-[#103120] py-4 rounded-xl font-bold hover:bg-[#103120] hover:text-white transition-all duration-300 cursor-pointer">
                            Lanjut Belanja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl border-2 border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <p class="text-gray-500 mb-2 text-xl font-semibold">Keranjang Belanja Kosong</p>
            <p class="text-gray-400 mb-6 text-sm">Yuk, mulai belanja produk-produk menarik kami!</p>
            <a href="{{ route('shop.index') }}" 
               class="inline-block bg-gradient-to-r from-[#103120] to-[#0d281a] text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection