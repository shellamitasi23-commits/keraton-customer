<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    // --- BAGIAN 1: KATALOG & KERANJANG ---

    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all();
        return view('customer.pages.shop.index', compact('products'));
    }

    // Menambah barang ke keranjang
    public function addToCart($id)
    {
        // Cek apakah user sudah punya produk ini di keranjang?
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($existingCart) {
            // Jika ada, tambah jumlahnya
            $existingCart->increment('quantity');
        } else {
            // Jika belum, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('shop.cart')->with('success', 'Produk masuk keranjang!');
    }

    // Menampilkan isi keranjang
    public function cart()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        // Hitung total belanjaan
        $subtotal = $carts->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('customer.pages.shop.cart', compact('carts', 'subtotal'));
    }
    // Tambahkan method ini di dalam ShopController

    // Update quantity (increase/decrease)
    public function updateCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

        if ($request->action === 'increase') {
            $cart->increment('quantity');
        } elseif ($request->action === 'decrease') {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            } else {
                // Jika quantity = 1 dan dikurangi, hapus item
                $cart->delete();
                return back()->with('success', 'Item dihapus dari keranjang.');
            }
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }
    // Menghapus item dari keranjang
    public function deleteCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    // --- BAGIAN 2: CHECKOUT & PEMBAYARAN ---

    // Menampilkan form alamat (Checkout)
    public function checkout()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('shop.index');
        }

        // Hitung-hitungan biaya
        $subtotal = $carts->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 15000; // Ongkir Fixed (Contoh)
        $service = 5000;   // Biaya Layanan
        $grandTotal = $subtotal + $shipping + $service;

        return view('customer.pages.shop.checkout', compact('carts', 'subtotal', 'shipping', 'service', 'grandTotal'));
    }

    // Proses Simpan Order (Pindah dari Cart ke Order)
    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'postal_code' => 'required',
            'whatsapp' => 'required',
        ]);

        $carts = Cart::with('product')->where('user_id', Auth::id())->get();

        // Hitung ulang total di server
        $subtotal = $carts->sum(fn($item) => $item->product->price * $item->quantity);
        $grandTotal = $subtotal + 15000 + 5000;

        // 1. Buat Data Order Utama
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'INV/MRC/' . date('Y') . '/' . strtoupper(Str::random(6)),
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'whatsapp' => $request->whatsapp,
            'subtotal' => $subtotal,
            'shipping_price' => 15000,
            'total_price' => $grandTotal,
            'status' => 'pending'
        ]);

        // 2. Pindahkan Detail Barang ke OrderItems
        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price
            ]);
        }

        // 3. Hapus Keranjang karena sudah dipesan
        Cart::where('user_id', Auth::id())->delete();

        // 4. Lanjut ke Pembayaran
        return redirect()->route('shop.payment', $order->id);
    }

    // Halaman Pilih Metode Pembayaran
    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('customer.pages.shop.payment', compact('order'));
    }

    // Proses Bayar Akhir
    public function processPayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $order->update([
            'status' => 'paid',
            'payment_method' => $request->payment_method ?? 'qris',
            'payment_proof' => 'auto-confirm.jpg'
        ]);

        // Redirect ke Profile untuk lihat Invoice
        return redirect()->route('profile.index')->with('show_invoice_shop', $order->id);
    }
}