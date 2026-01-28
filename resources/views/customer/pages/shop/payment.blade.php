@extends('customer.layouts.master')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12 pb-32">
    
    <div class="text-center mb-10">
        <h1 class="serif text-3xl font-bold text-[#103120]">Pilih Pembayaran</h1>
        <p class="text-gray-500 mt-2">Selesaikan pembayaran untuk memproses pesanan Anda</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        <div class="bg-[#F9F9F7] p-6 border-b border-gray-200 text-center">
            <span class="text-sm text-gray-500 uppercase tracking-wide font-bold">Total Tagihan</span>
            <div class="text-4xl font-bold text-[#E89020] mt-2">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Order ID: #{{ $order->order_number }}</div>
        </div>

        <form action="{{ route('shop.payment.process', $order->id) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            
            <h3 class="font-bold text-gray-800 mb-4">Metode Pembayaran:</h3>

<label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 has-[:checked]:border-[#103120] has-[:checked]:bg-[#103120]/5 mb-4 group">
    <div class="flex items-center h-5">
        <input type="radio" name="payment_method" value="qris" class="w-4 h-4 text-[#103120] border-gray-300 focus:ring-[#103120]" checked onclick="toggleMethod('qris')">
    </div>
    <div class="ml-3 text-sm w-full">
        <div class="font-bold text-gray-900 flex justify-between items-center">
            <span>QRIS (Instant)</span>
        </div>
        <p class="text-gray-500 text-xs mt-1">Scan menggunakan GoPay, OVO, Dana, ShopeePay, BCA Mobile.</p>
        
        <div id="content-qris" class="mt-4 p-4 bg-white border rounded-lg text-center method-content">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" class="w-32 h-32 mx-auto object-contain">
            <p class="text-xs text-gray-400 mt-2">NMID: ID123456789</p>
        </div>
    </div>
</label>

<label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                <div class="flex items-center h-5">
                    <input type="radio" name="payment_method" value="bank_transfer" class="w-4 h-4 text-[#103120] border-gray-300 focus:ring-[#103120]" onclick="toggleMethod('bank')">
                </div>
                <div class="ml-3 text-sm w-full">
                    <div class="font-bold text-gray-900 flex justify-between">
                        <span>Transfer Bank (Manual)</span>
                        <span class="text-xs bg-gray-200 px-2 py-0.5 rounded text-gray-600">Cek Manual</span>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Transfer ke rekening BCA / Mandiri Keraton.</p>

                    <div id="bankContent" style="display: none;" class="mt-4 bg-blue-50 p-4 rounded-lg space-y-3">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" class="h-8">
                            <div>
                                <p class="font-bold text-lg text-gray-800">8880 1234 5678</p>
                                <p class="text-xs text-gray-500">A.n Yayasan Keraton Kasepuhan</p>
                            </div>
                        </div>
                        <div class="text-xs bg-yellow-50 p-3 rounded text-yellow-800 border border-yellow-100">
                            <strong>Penting:</strong> Masukkan <u>{{ $order->order_number }}</u> pada berita transfer.
                        </div>
                    </div>
                </div>
            </label>

            <button type="submit" class="w-full bg-[#103120] text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-green-900 transition transform hover:-translate-y-0.5 active:translate-y-0">
                Saya Sudah Membayar
            </button>
        </form>
    </div>
</div>

<script>
    function toggleMethod(method) {
        // Sembunyikan semua konten dulu
        document.getElementById('content-qris').classList.add('hidden');
        document.getElementById('content-bank').classList.add('hidden');

        // Tampilkan yang dipilih
        if(method === 'qris') {
            document.getElementById('content-qris').classList.remove('hidden');
        } else {
            document.getElementById('content-bank').classList.remove('hidden');
        }
    }
</script>
@endsection