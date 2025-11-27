@extends('layouts.master')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-6">
        
<div class="bg-[#7A9E89] text-white p-8 rounded-lg shadow-lg flex flex-col md:flex-row items-center gap-6 mb-8">
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                @csrf
                <div class="relative w-24 h-24 group cursor-pointer">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&size=128' }}" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md"
                         alt="Foto Profil">
                    
                    <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300"
                         onclick="document.getElementById('avatarInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*" onchange="document.getElementById('avatarForm').submit()">
                </div>
            </form>

            <div class="text-center md:text-left">
                <h2 class="serif text-3xl font-bold">{{ Auth::user()->name }}</h2>
                <p class="opacity-90">{{ Auth::user()->email }}</p>
                <p class="opacity-90">{{ Auth::user()->phone }}</p>
                @if(session('success'))
                    <p class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded mt-2 inline-block font-bold">
                        ✅ {{ session('success') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8 overflow-hidden">
            <div class="flex border-b overflow-x-auto">
                <button onclick="switchTab('profile')" id="btn-profile" class="flex-1 py-4 font-bold text-[#103120] border-b-2 border-[#E89020] hover:bg-gray-50 transition min-w-[120px]">
                    👤 Data Diri
                </button>
                <button onclick="switchTab('ticket')" id="btn-ticket" class="flex-1 py-4 text-gray-500 hover:text-[#103120] hover:bg-gray-50 transition min-w-[120px]">
                    🎫 Riwayat Tiket
                </button>
                <button onclick="switchTab('merchandise')" id="btn-merchandise" class="flex-1 py-4 text-gray-500 hover:text-[#103120] hover:bg-gray-50 transition min-w-[120px]">
                    🛍️ Merchandise
                </button>
            </div>

            <div class="p-8 min-h-[400px]">

                <div id="content-profile" class="block animate-fade-in">
                    <h3 class="font-bold text-xl mb-6">Informasi Akun</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-600 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-gray-200 border-none rounded p-3 text-gray-700 font-medium cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 mb-2">Email</label>
                            <input type="text" value="{{ Auth::user()->email }}" class="w-full bg-gray-200 border-none rounded p-3 text-gray-700 font-medium cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 mb-2">Nomor Telepon</label>
                            <input type="text" value="{{ Auth::user()->phone }}" class="w-full bg-gray-200 border-none rounded p-3 text-gray-700 font-medium cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-600 mb-2">ID Pengguna</label>
                            <input type="text" value="USER-{{ str_pad(Auth::id(), 5, '0', STR_PAD_LEFT) }}" class="w-full bg-gray-200 border-none rounded p-3 text-gray-700 font-medium cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <div class="bg-[#9AB3A5] bg-opacity-80 rounded-lg p-6 border border-[#7A9E89] text-white shadow-inner">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h4 class="font-bold text-lg">Ringkasan Aktivitas</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-8 text-center md:text-left">
                            <div>
                                <p class="text-sm opacity-80 mb-1">Total Tiket Dibeli</p>
                                <p class="text-3xl font-bold">{{ $tickets->sum('total_ticket') }}</p>
                            </div>
                            <div>
                                <p class="text-sm opacity-80 mb-1">Total Transaksi Barang</p>
                                <p class="text-3xl font-bold">{{ $orders->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="content-ticket" class="hidden">
                    <h3 class="font-bold text-xl mb-6">Tiket Saya</h3>
                    @if($tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($tickets as $ticket)
                            <div class="bg-[#9AB3A5] bg-opacity-20 border border-[#9AB3A5] p-6 rounded-lg flex flex-col md:flex-row justify-between items-center gap-4">
                                <div>
                                    <h4 class="font-bold text-lg text-[#103120]">{{ $ticket->ticket_category->name }}</h4>
                                    <p class="text-sm text-gray-600">📅 {{ \Carbon\Carbon::parse($ticket->visit_date)->translatedFormat('d F Y') }} • {{ $ticket->total_ticket }} Orang</p>
                                    <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-bold">LUNAS</span>
                                </div>
                                <button onclick='openTicketInvoice(@json($ticket))' class="bg-[#103120] text-white px-4 py-2 rounded text-sm hover:bg-green-900 flex items-center gap-2">
                                    <span>📄</span> Invoice
                                </button>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded border border-dashed">
                            <p class="text-gray-400 italic">Belum ada tiket yang dibeli.</p>
                            <a href="{{ route('tiket.index') }}" class="text-[#E89020] font-bold text-sm underline mt-2 block">Pesan Tiket Sekarang</a>
                        </div>
                    @endif
                </div>

                <div id="content-merchandise" class="hidden">
                    <h3 class="font-bold text-xl mb-6">Pesanan Barang</h3>
                    @if($orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($orders as $order)
                            <div class="bg-orange-50 border border-orange-200 p-6 rounded-lg flex flex-col md:flex-row justify-between md:items-center gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-[#103120] text-lg">Order #{{ substr($order->order_number, -6) }}</span>
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded font-bold">LUNAS</span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $order->items->count() }} Barang • Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Dikirim ke: {{ Str::limit($order->address, 40) }}</p>
                                </div>
                                <button onclick='openShopInvoice(@json($order))' class="bg-[#E89020] text-white px-4 py-2 rounded text-sm hover:bg-orange-700 flex items-center gap-2 w-fit">
                                    <span>📦</span> Detail & Invoice
                                </button>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded border border-dashed">
                            <p class="text-gray-400 italic">Belum ada merchandise yang dibeli.</p>
                            <a href="{{ route('shop.index') }}" class="text-[#E89020] font-bold text-sm underline mt-2 block">Mulai Belanja</a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<dialog id="ticketModal" class="p-0 rounded-lg shadow-2xl backdrop:bg-black/60 w-[400px]">
    <div class="bg-white p-6">
        <h3 class="serif text-2xl font-bold text-center text-[#103120]">Invoice Tiket</h3>
        <p id="tkt-code" class="text-center text-xs text-gray-500 mb-4">-</p>
        
        <div class="flex justify-center mb-4">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TIKET" class="w-32 h-32 border p-2">
        </div>
        <div class="bg-green-100 text-green-800 text-center py-2 rounded text-sm font-bold mb-4">✅ Pembayaran Berhasil</div>

        <div class="space-y-2 text-sm border-t pt-4">
            <div class="flex justify-between"><span>Nama</span><span class="font-bold">{{ Auth::user()->name }}</span></div>
            <div class="flex justify-between"><span>Tanggal</span><span id="tkt-date" class="font-bold">-</span></div>
            <div class="flex justify-between"><span>Kategori</span><span id="tkt-name" class="font-bold text-right w-1/2">-</span></div>
            <div class="flex justify-between"><span>Jumlah</span><span id="tkt-qty" class="font-bold">-</span></div>
        </div>
        <div class="border-t mt-4 pt-4 flex justify-between font-bold text-lg">
            <span>Total</span><span id="tkt-total" class="text-[#103120]">-</span>
        </div>
        <form method="dialog" class="mt-6"><button class="w-full bg-gray-200 py-3 rounded font-bold hover:bg-gray-300 transition">Tutup</button></form>
    </div>
</dialog>

<dialog id="shopModal" class="p-0 rounded-lg shadow-2xl backdrop:bg-black/60 w-[450px]">
    <div class="bg-white p-0 overflow-hidden">
        <div class="bg-[#103120] p-6 text-white text-center">
            <h3 class="serif text-2xl font-bold">Invoice Merchandise</h3>
            <p id="shp-number" class="text-xs opacity-80 mt-1">INV/MRC/...</p>
        </div>
        
        <div class="p-6">
            <div class="bg-green-100 text-green-800 text-center py-2 rounded text-sm font-bold mb-6">✅ Pembayaran Berhasil</div>

            <div class="mb-6">
                <h4 class="font-bold text-sm mb-2 border-b pb-1">Informasi Pemesan</h4>
                <div class="text-sm grid grid-cols-3 gap-y-1">
                    <span class="text-gray-500">Nama</span> <span class="col-span-2 font-medium text-right">{{ Auth::user()->name }}</span>
                    <span class="text-gray-500">Email</span> <span class="col-span-2 font-medium text-right">{{ Auth::user()->email }}</span>
                    <span class="text-gray-500">Telepon</span> <span class="col-span-2 font-medium text-right">{{ Auth::user()->phone }}</span>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded mb-6 text-sm">
                <div class="flex items-start gap-2">
                    <span class="text-lg">📍</span>
                    <div>
                        <span class="font-bold block text-gray-700">Alamat Pengiriman</span>
                        <p id="shp-address" class="text-gray-600 leading-tight mt-1">-</p>
                        <p id="shp-postal" class="text-gray-500 text-xs mt-1">Kode Pos: -</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="font-bold text-sm mb-2 border-b pb-1">Detail Pesanan</h4>
                <div id="shp-items" class="space-y-2 text-sm max-h-32 overflow-y-auto pr-2">
                    </div>
            </div>

            <div class="border-t pt-4 space-y-1 text-sm">
                <div class="flex justify-between"><span>Subtotal Produk</span> <span id="shp-subtotal">-</span></div>
                <div class="flex justify-between"><span>Ongkir (JNE)</span> <span id="shp-shipping">-</span></div>
                <div class="flex justify-between font-bold text-lg mt-2 pt-2 border-t border-dashed">
                    <span>Total Bayar</span> <span id="shp-total" class="text-[#E89020]">-</span>
                </div>
            </div>

            <form method="dialog" class="mt-8">
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 rounded font-bold transition">Tutup Invoice</button>
            </form>
        </div>
    </div>
</dialog>

<script>
    // 1. FUNGSI GANTI TAB (UPDATE: Support 3 Tab)
    function switchTab(tabName) {
        // Reset Style Tombol
        const buttons = ['profile', 'ticket', 'merchandise'];
        buttons.forEach(btn => {
            document.getElementById('btn-' + btn).className = "flex-1 py-4 text-gray-500 hover:text-[#103120] hover:bg-gray-50 transition min-w-[120px]";
            document.getElementById('content-' + btn).className = "hidden";
        });
        
        // Aktifkan Tab yang dipilih
        document.getElementById('btn-' + tabName).className = "flex-1 py-4 font-bold text-[#103120] border-b-2 border-[#E89020] bg-white transition min-w-[120px]";
        document.getElementById('content-' + tabName).className = "block animate-fade-in";
    }

    // 2. INVOICE TIKET
    function openTicketInvoice(data) {
        document.getElementById('tkt-code').innerText = data.transaction_code;
        document.getElementById('tkt-name').innerText = data.ticket_category.name;
        document.getElementById('tkt-qty').innerText = data.total_ticket + ' Tiket';
        document.getElementById('tkt-total').innerText = 'Rp ' + parseInt(data.total_price).toLocaleString('id-ID');
        document.getElementById('tkt-date').innerText = data.visit_date; 
        document.getElementById('ticketModal').showModal();
    }

    // 3. INVOICE SHOP
    function openShopInvoice(order) {
        document.getElementById('shp-number').innerText = order.order_number;
        document.getElementById('shp-address').innerText = order.address;
        document.getElementById('shp-postal').innerText = order.postal_code;

        let itemsHtml = '';
        order.items.forEach(item => {
            let totalItemPrice = item.price * item.quantity;
            itemsHtml += `
                <div class="flex justify-between items-center">
                    <div>
                        <span class="font-bold block text-gray-800">${item.product.name}</span>
                        <span class="text-xs text-gray-500">${item.quantity} x Rp ${parseInt(item.price).toLocaleString('id-ID')}</span>
                    </div>
                    <span class="font-bold text-gray-700">Rp ${totalItemPrice.toLocaleString('id-ID')}</span>
                </div>
            `;
        });
        document.getElementById('shp-items').innerHTML = itemsHtml;
        document.getElementById('shp-subtotal').innerText = 'Rp ' + parseInt(order.subtotal).toLocaleString('id-ID');
        document.getElementById('shp-shipping').innerText = 'Rp ' + parseInt(order.shipping_price).toLocaleString('id-ID');
        document.getElementById('shp-total').innerText = 'Rp ' + parseInt(order.total_price).toLocaleString('id-ID');

        document.getElementById('shopModal').showModal();
    }

    // 4. AUTO OPEN LOGIC
    @if(session('show_invoice'))
        switchTab('ticket');
        <?php $latestTkt = $tickets->first(); ?>
        @if($latestTkt && $latestTkt->id == session('show_invoice'))
            openTicketInvoice(@json($latestTkt));
        @endif
    @elseif(session('show_invoice_shop'))
        switchTab('merchandise');
        <?php $latestOrder = $orders->first(); ?>
        @if($latestOrder && $latestOrder->id == session('show_invoice_shop'))
            openShopInvoice(@json($latestOrder));
        @endif
    @else
        // DEFAULT TAB SAAT BUKA HALAMAN: PROFILE
        switchTab('profile');
    @endif
</script>
@endsection