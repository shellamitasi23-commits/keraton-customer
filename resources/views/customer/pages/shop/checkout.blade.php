@extends('customer.layouts.master')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm animate-fade-in-down">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Mohon periksa inputan berikut:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('shop.processCheckout') }}" method="POST" id="checkoutForm">
            @csrf
            
            {{-- LAYOUT GRID: 1 Kolom di HP, 3 Kolom di Laptop (2 Kiri : 1 Kanan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">

                {{-- KOLOM KIRI: FORM PENGIRIMAN (Mengambil 2 bagian di layar besar) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 sm:p-8 border-b border-gray-100 bg-white">
                            <h1 class="serif text-2xl sm:text-3xl font-bold text-[#103120] flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#E89020]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Detail Pengiriman
                            </h1>
                            <p class="text-gray-500 mt-2 text-sm">Lengkapi alamat pengiriman agar pesanan sampai dengan aman.</p>
                        </div>

                        <div class="p-6 sm:p-8 space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="4" 
                                          class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#103120] focus:ring focus:ring-[#103120]/20 transition text-gray-700 text-sm p-4 placeholder-gray-400"
                                          placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan..." required>{{ old('address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Pos <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                           class="w-full border-gray-300 h-10 shadow-sm focus:border-[#103120] focus:ring focus:ring-[#103120]/20 transition text-gray-700 text-sm p-3.5"
                                           placeholder="Contoh: 45123" required>
                                </div>

                                {{-- Input WhatsApp --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                                    <input type="text" name="whatsapp" value="{{ old('whatsapp', Auth::user()->phone ?? '') }}" 
                                           class="w-full border-gray-300 h-10 shadow-sm focus:border-[#103120] focus:ring focus:ring-[#103120]/20 transition text-gray-700 text-sm p-3.5"
                                           placeholder="0812xxxxxx" required>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100 text-blue-800 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <p>Pastikan nomor WhatsApp aktif untuk konfirmasi pengiriman dari kurir.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-24">
                        <div class="p-6 bg-[#103120] text-white">
                            <h3 class="serif text-xl font-bold">Ringkasan Pesanan</h3>
                            <p class="text-white/80 text-xs mt-1">{{ count($cartItems) }} Item di keranjang</p>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal Barang</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span class="flex items-center gap-2">
                                    Ongkir (Flat)
                                    <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-full">JNE</span>
                                </span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($shippingPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Biaya Layanan</span>
                                <span class="font-bold text-green-600">Gratis</span>
                            </div>

                            <div class="border-t border-dashed border-gray-200 my-4"></div>

                            <div class="flex justify-between items-end">
                                <span class="text-sm font-bold text-gray-800">Total Tagihan</span>
                                <span class="text-2xl font-bold text-[#E89020]">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <p class="text-[10px] text-gray-400 text-right mt-1">*Sudah termasuk pajak</p>

                            <button type="submit" 
                                    class="w-full mt-6 bg-[#103120] text-white py-4 rounded-xl font-bold text-base shadow-lg hover:bg-[#0d281a] hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer">
                                <span>Lanjut ke Pembayaran</span>
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        console.log('Form disubmit!');
        console.log('Action:', this.action);
        console.log('Method:', this.method);
    });
</script>

<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection