@extends('layouts.master')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-6">
        
        <h1 class="serif text-3xl font-bold text-[#103120] mb-8">Pembayaran</h1>

        <div class="bg-white p-8 rounded-lg shadow-md mb-6">
            <p class="text-gray-500 mb-2">Total Tagihan:</p>
            <p class="text-3xl font-bold text-green-600 mb-6">Rp {{ number_format($transaction->total_price ?? $order->total_price, 0, ',', '.') }}</p>

            <form action="{{ route('tiket.process', $transaction->id) }}" method="POST">
                @csrf
                <h3 class="font-bold text-lg mb-4">Pilih Metode Pembayaran</h3>

                <div class="space-y-4 mb-8">
                    
                    <label class="relative flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-[#103120] has-[:checked]:bg-green-50 transition">
                        <input type="radio" name="payment_method" value="qris" class="w-5 h-5 accent-[#103120]" onchange="showPayment('qris')">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span>📱</span>
                                <span class="font-bold">QRIS</span>
                            </div>
                            <p class="text-xs text-gray-500">Scan code menggunakan GoPay, OVO, Dana, dll.</p>
                        </div>
                    </label>

                    <label class="relative flex items-center gap-4 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-[#103120] has-[:checked]:bg-green-50 transition">
                        <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 accent-[#103120]" onchange="showPayment('transfer')" checked>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span>💳</span>
                                <span class="font-bold">Transfer Bank</span>
                            </div>
                            <p class="text-xs text-gray-500">Transfer Manual ke Bank BCA</p>
                        </div>
                    </label>

                </div>

                <div id="info-transfer" class="bg-gray-100 p-5 rounded border border-gray-200 mb-8 text-sm block">
                    <p class="font-bold mb-2">Rekening Tujuan:</p>
                    <p class="text-lg">BCA: <strong class="text-[#103120]">1239049003</strong></p>
                    <p>A.n: Keraton Kasepuhan Cirebon</p>
                    <hr class="border-gray-300 my-3">
                    <p class="text-xs text-gray-500">Silakan upload bukti transfer setelah melakukan pembayaran.</p>
                </div>

                <div id="info-qris" class="bg-gray-100 p-5 rounded border border-gray-200 mb-8 text-sm hidden text-center">
                    <p class="font-bold mb-4">Scan QRIS di bawah ini:</p>
                    <div class="bg-white p-4 inline-block rounded shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=KERATON-PAYMENT-DUMMY" alt="QRIS Dummy" class="w-48 h-48">
                    </div>
                    <p class="text-xs text-gray-500 mt-4">NMID: ID1234567890123</p>
                    <p class="text-xs text-gray-500">A.n Keraton Kasepuhan</p>
                </div>

                <button type="submit" class="w-full bg-[#103120] text-white py-4 rounded font-bold hover:bg-green-900 transition">
                    Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function showPayment(type) {
        // Ambil elemen div
        const transferInfo = document.getElementById('info-transfer');
        const qrisInfo = document.getElementById('info-qris');

        if (type === 'qris') {
            // Jika pilih QRIS: Sembunyikan Transfer, Munculkan QRIS
            transferInfo.classList.add('hidden');
            qrisInfo.classList.remove('hidden');
        } else {
            // Jika pilih Transfer: Sembunyikan QRIS, Munculkan Transfer
            qrisInfo.classList.add('hidden');
            transferInfo.classList.remove('hidden');
        }
    }
</script>
@endsection