@extends('customer.layouts.master')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <h1 class="serif text-2xl font-bold mb-6">Pengiriman</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <form action="{{ route('shop.processCheckout') }}" method="POST" id="formCheckout">
            @csrf
            <div class="mb-4">
                <label class="block font-bold text-sm mb-1">Alamat Lengkap</label>
                <textarea name="address" class="w-full border p-2 rounded focus:outline-none focus:border-[#103120]" rows="3" required placeholder="Jalan, Nomor Rumah, RT/RW..."></textarea>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-sm mb-1">Kode Pos</label>
                <input type="text" name="postal_code" class="w-full border p-2 rounded focus:outline-none focus:border-[#103120]" required>
            </div>
            <div class="mb-4">
                <label class="block font-bold text-sm mb-1">WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ Auth::user()->phone }}" class="w-full border p-2 rounded focus:outline-none focus:border-[#103120]" required>
            </div>
        </form>

        <div class="bg-gray-50 p-6 rounded h-fit border border-gray-200">
            <h3 class="font-bold mb-4 text-[#103120]">Ringkasan Biaya</h3>
            
            <div class="flex justify-between mb-2 text-sm text-gray-600">
                <span>Subtotal Barang</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mb-2 text-sm text-gray-600">
                <span>Ongkir (Flat)</span>
                <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mb-4 text-sm text-gray-600">
                <span>Biaya Layanan</span>
                <span>Rp {{ number_format($service, 0, ',', '.') }}</span>
            </div>
            
            <div class="border-t border-dashed border-gray-300 pt-4 flex justify-between font-bold text-lg mb-6 text-[#103120]">
                <span>Total Tagihan</span>
                <span class="text-[#E89020]">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>
            
            <button onclick="document.getElementById('formCheckout').submit()" class="w-full bg-[#103120] text-white py-3 rounded font-bold hover:bg-green-900 transition shadow-lg">
                Lanjut Bayar
            </button>
        </div>
    </div>
</div>
@endsection