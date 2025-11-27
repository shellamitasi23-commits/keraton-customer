@extends('layouts.master')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <h1 class="serif text-3xl font-bold mb-6 text-[#103120]">Keranjang Belanja</h1>

    @if($carts->count() > 0)
        <div class="bg-white rounded shadow overflow-hidden mb-6">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Produk</th>
                        <th class="p-4">Harga</th>
                        <th class="p-4">Jumlah</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carts as $cart)
                    <tr class="border-b">
                        <td class="p-4 flex items-center gap-3">
    <div class="w-16 h-16 rounded overflow-hidden bg-gray-200 shrink-0">
        <img src="{{ asset('images/products/' . $cart->product->image) }}" 
             class="w-full h-full object-cover"
             onerror="this.src='https://via.placeholder.com/100?text=No+Image'">
    </div>
    <span class="font-bold">{{ $cart->product->name }}</span>
</td>
                        <td class="p-4">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                        <td class="p-4">{{ $cart->quantity }}</td>
                        <td class="p-4">
                            <form action="{{ route('shop.delete', $cart->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-500 underline text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center bg-gray-50 p-6 rounded">
            <div>
                <span class="text-gray-500">Subtotal:</span>
                <span class="text-2xl font-bold ml-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('shop.checkout') }}" class="bg-[#103120] text-white px-8 py-3 rounded font-bold hover:bg-green-900">
                Checkout
            </a>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded border border-dashed">
            <p class="text-gray-400 mb-4">Keranjang kosong.</p>
            <a href="{{ route('shop.index') }}" class="text-[#103120] font-bold underline">Belanja Sekarang</a>
        </div>
    @endif
</div>
@endsection