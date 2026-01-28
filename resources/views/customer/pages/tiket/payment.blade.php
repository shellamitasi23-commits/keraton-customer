@extends('customer.layouts.master')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12 pb-32">
    
    <div class="text-center mb-10">
        <h1 class="serif text-3xl font-bold text-[#103120]">Pilih Pembayaran</h1>
        <p class="text-gray-500 mt-2">Selesaikan pembayaran untuk memproses pembelian tiket Anda</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <strong class="font-bold">Terjadi kesalahan!</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        <div class="bg-[#F9F9F7] p-6 border-b border-gray-200 text-center">
            <span class="text-sm text-gray-500 uppercase tracking-wide font-bold">Total Tagihan</span>
            <div class="text-4xl font-bold text-[#E89020] mt-2">
                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Transaction ID: #{{ $transaction->id }}</div>
        </div>

        <form action="{{ route('tiket.process', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            
            <h3 class="font-bold text-gray-800 mb-4">Metode Pembayaran:</h3>

            <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 has-[:checked]:border-[#103120] has-[:checked]:bg-[#103120]/5 mb-4 group">
                <div class="flex items-center h-5">
                    <input type="radio" name="payment_method" value="qris" class="w-4 h-4 text-[#103120] border-gray-300 focus:ring-[#103120]" onclick="toggleMethod('qris')">
                </div>
                <div class="ml-3 text-sm w-full">
                    <div class="font-bold text-gray-900 flex justify-between items-center">
                        <span>QRIS (Instant)</span>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Scan menggunakan GoPay, OVO, Dana, ShopeePay, BCA Mobile.</p>
                    
                    <div id="content-qris" class="mt-4 p-4 bg-white border rounded-lg text-center method-content hidden">
                        <p class="font-bold mb-3 text-gray-700">Scan QRIS di bawah ini:</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=KERATON-PAYMENT-DUMMY" 
                             alt="QRIS Code" 
                             class="w-32 h-32 mx-auto object-contain">
                        <p class="text-xs text-gray-400 mt-3">NMID: ID1234567890123</p>
                        <p class="text-xs text-gray-500">A.n Keraton Kasepuhan</p>
                    </div>
                </div>
            </label>

            <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition hover:bg-gray-50 has-[:checked]:border-[#103120] has-[:checked]:bg-[#103120]/5 mb-8 group">
                <div class="flex items-center h-5">
                    <input type="radio" name="payment_method" value="transfer" class="w-4 h-4 text-[#103120] border-gray-300 focus:ring-[#103120]" checked onclick="toggleMethod('bank')">
                </div>
                <div class="ml-3 text-sm w-full">
                    <div class="font-bold text-gray-900 flex justify-between items-center">
                        <span>Transfer Bank (Manual)</span>
                        <span class="text-xs bg-gray-200 px-2 py-0.5 rounded text-gray-600">Cek Manual</span>
                    </div>
                    <p class="text-gray-500 text-xs mt-1">Transfer ke rekening BCA Keraton.</p>

                    <div id="content-bank" class="mt-4 p-4 bg-white border rounded-lg method-content">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/2560px-Bank_Central_Asia.svg.png" 
                                 class="h-6 w-auto object-contain">
                            <div>
                                <p class="font-bold text-lg text-gray-800">1239 0490 03</p>
                                <p class="text-xs text-gray-500">A.n Keraton Kasepuhan Cirebon</p>
                            </div>
                        </div>
                        <div class="text-xs bg-yellow-50 p-3 rounded text-yellow-800 border border-yellow-100">
                            <strong>Penting:</strong> Masukkan <u>TRX-{{ $transaction->id }}</u> pada berita transfer.
                        </div>
                    </div>
                </div>
            </label>

            <button type="submit" class="w-full bg-[#103120] text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-green-900 transition transform hover:-translate-y-0.5 active:translate-y-0">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    function toggleMethod(method) {
        document.getElementById('content-qris').classList.add('hidden');
        document.getElementById('content-bank').classList.add('hidden');

        if(method === 'qris') {
            document.getElementById('content-qris').classList.remove('hidden');
        } else {
            document.getElementById('content-bank').classList.remove('hidden');
        }
    }
</script>
@endsection