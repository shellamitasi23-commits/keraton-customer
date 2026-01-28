@extends('customer.layouts.master')

@section('content')
<div class="relative h-[400px] w-full bg-gray-900">
    <img src="images/background-tiket.jpg" class="absolute w-full h-full object-cover opacity-60">
    
    <div class="relative z-10 max-w-7xl mx-auto h-full flex flex-col justify-center px-6 text-white">
        <h1 class="serif text-5xl font-bold mb-2 text-[#E89020]">Pemesanan Tiket</h1>
        <p class="text-lg opacity-90">Pilih jenis tiket dan tanggal kunjungan Anda.</p>
    </div>
</div>

<form action="{{ route('tiket.order') }}" method="POST" class="bg-gray-100 min-h-screen py-12">
    @csrf
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            @foreach($tickets as $ticket)
            <div class="bg-white p-6 rounded-lg shadow-sm flex flex-col md:flex-row gap-6 items-center border border-gray-100 hover:shadow-md transition">
                
                <div class="w-full md:w-48 h-32 bg-gray-200 rounded-md overflow-hidden relative group shrink-0">
                    <img src="{{ asset('storage/' . $ticket->image) }}" 
                         class="w-full h-full object-cover transition duration-500 group-hover:scale-110" 
                         alt="{{ $ticket->name }}"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'"> 
                </div>
                <div class="flex-1 w-full">
                    <h3 class="font-bold text-xl text-[#103120]">{{ $ticket->name }}</h3>
                    <p class="text-xs text-red-500 mb-2">*{{ $ticket->description }}</p>
                    
                    <div class="flex justify-between items-end mt-4">
                        <div class="text-lg font-bold">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }} 
                            <span class="text-xs font-normal text-gray-500">/ Orang</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="updateQty({{ $ticket->id }}, -1)" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition cursor-pointer">-</button>
                            
                            <input type="number" 
                                   id="qty-{{ $ticket->id }}" 
                                   name="tickets[{{ $ticket->id }}]" 
                                   value="0" 
                                   class="w-12 text-center border-none font-bold bg-transparent" 
                                   readonly
                                   data-price="{{ $ticket->price }}"
                                   data-name="{{ $ticket->name }}">
                                   
                            <button type="button" onclick="updateQty({{ $ticket->id }}, 1)" class="w-8 h-8 rounded-full bg-[#103120] text-white flex items-center justify-center hover:bg-green-900 transition cursor-pointer">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="space-y-6">
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="font-bold mb-4 text-[#103120]">Tanggal Kunjungan</h3>
                <input type="date" name="visit_date" class="w-full p-3 rounded border border-gray-300 focus:outline-none focus:border-[#103120] focus:ring-1 focus:ring-[#103120] cursor-pointer" required>
            </div>
            
            <div class="bg-[#1F3B2B] text-white p-6 rounded-lg shadow-lg sticky top-24">
                <div class="flex items-center gap-2 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="serif text-xl font-bold">Ringkasan Pesanan</h3>
                </div>

                <div id="summary-list" class="space-y-3 text-sm mb-6 border-b border-gray-600 pb-4 min-h-[100px]">
                    <p class="text-gray-400 italic text-center py-4">Belum ada tiket yang dipilih.</p>
                </div>

                <div class="flex justify-between items-center text-lg font-bold mb-6">
                    <span>Total Bayar</span>
                    <span id="grand-total" class="text-[#E89020]">Rp 0</span>
                </div>

                @auth
                    <button type="submit" class="w-full h-12 bg-[#E89020] text-white font-bold py-4 rounded hover:bg-orange-400  transition cursor-pointer">
                        Lanjut Pembayaran
                    </button>
                @else
                    <button type="button" onclick="document.getElementById('loginModal').showModal()" class="w-full h-12 bg-gray-500 text-white font-bold py-4 rounded hover:bg-gray-600 transition cursor-not-allowed">
                        Login untuk Memesan
                    </button>
                @endauth
            </div>

        </div>
    </div>
</form>

<script>
    function updateQty(id, change) {
        let input = document.getElementById('qty-' + id);
        let currentQty = parseInt(input.value);
        let newQty = currentQty + change;

        if (newQty >= 0) {
            input.value = newQty;
            updateSummary();
        }
    }

    function updateSummary() {
        let inputs = document.querySelectorAll('input[name^="tickets"]');
        let summaryList = document.getElementById('summary-list');
        let grandTotalEl = document.getElementById('grand-total');
        let total = 0;
        let html = '';

        inputs.forEach(input => {
            let qty = parseInt(input.value);
            let price = parseFloat(input.dataset.price);
            let name = input.dataset.name;

            if (qty > 0) {
                let subtotal = qty * price;
                total += subtotal;
                html += `
                    <div class="flex justify-between items-center animate-fade-in">
                        <div>
                            <span class="block font-bold">${name}</span>
                            <span class="text-xs text-gray-400">x${qty}</span>
                        </div>
                        <span class="font-bold">Rp ${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                `;
            }
        });

        if (html === '') {
            summaryList.innerHTML = '<p class="text-gray-400 italic text-center py-4">Belum ada tiket yang dipilih.</p>';
        } else {
            summaryList.innerHTML = html;
        }

        grandTotalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection