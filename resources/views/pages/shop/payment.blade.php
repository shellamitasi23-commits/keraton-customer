@extends('layouts.master')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-6">
        
        <h1 class="serif text-3xl font-bold text-[#103120] mb-2">Pembayaran Merchandise</h1>
        <p class="text-gray-500 mb-8">Order ID: {{ $order->order_number }}</p>

        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <p class="text-gray-500 mb-2">Total Tagihan:</p>
            <p class="text-3xl font-bold text-[#E89020] mb-6">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

            <form action="{{ route('shop.pay', $order->id) }}" method="POST">
                @csrf
                <h3 class="font-bold text-lg mb-4">Pilih Metode Pembayaran</h3>

                <div class="space-y-4 mb-8">
                    
                    <label class="relative flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-[#E89020] has-[:checked]:bg-orange-50 transition">
                        <input type="radio" name="payment_method" value="qris" class="w-5 h-5 accent-[#E89020]" checked>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-2xl">📱</span>
                                <span class="font-bold">QRIS</span>
                            </div>
                            <p class="text-xs text-gray-500">Otomatis cek verifikasi (Simulasi)</p>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-[#E89020] has-[:checked]:bg-orange-50 transition">
                        <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 accent-[#E89020]">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-2xl">💳</span>
                                <span class="font-bold">Transfer Bank</span>
                            </div>
                            <p class="text-xs text-gray-500">BCA Manual Check</p>
                        </div>
                    </label>

                </div>

                <div class="bg-blue-50 text-blue-800 p-4 rounded text-sm mb-6 flex gap-3 items-start">
                    <span class="text-xl">🚚</span>
                    <div>
                        <strong>Info Pengiriman:</strong><br>
                        Barang akan dikirim ke alamat: {{ $order->address }}
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#103120] text-white py-4 rounded font-bold hover:bg-green-900 transition">
                    Bayar & Selesaikan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection