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
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return back()->with('error', 'Produk habis!');
        }

        $quantity = $request->quantity ?? 1;

        if ($quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok tersedia!');
            }

            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    // Menampilkan isi keranjang
  public function cart()
{
    $carts = Cart::where('user_id', Auth::id())
        ->with('product')
        ->get();

    // Hitung subtotal
    $subtotal = $carts->sum(function ($cart) {
        return $cart->product->price * $cart->quantity;
    });

    // Hitung ongkir & total
    $shippingPrice = 15000; // JNE
    $total = $subtotal + $shippingPrice;

    // Kirim semua variabel ke view
    return view('customer.pages.shop.cart', compact('carts', 'subtotal', 'shippingPrice', 'total'));
}

    // Update quantity (increase/decrease)
    public function updateCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cart->product->stock
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }
    // Menghapus item dari keranjang
    public function deleteCart($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    // --- BAGIAN 2: CHECKOUT & PEMBAYARAN ---

    // Menampilkan form alamat (Checkout)
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingPrice = 15000;
        $grandTotal = $subtotal + $shippingPrice;

        return view(
            'customer.pages.shop.checkout',
            compact('cartItems', 'subtotal', 'shippingPrice', 'grandTotal')
        );
    }

    public function processCheckout(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:500',
        'postal_code' => 'required|string|max:10',
    ]);

    $carts = Cart::where('user_id', Auth::id())->with('product')->get();

    if ($carts->isEmpty()) {
        return redirect()->route('shop.index')->with('error', 'Keranjang kosong!');
    }

    // Hitung total
    $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
    $shippingPrice = 15000;
    $total = $subtotal + $shippingPrice;

    // Buat Order
    $order = Order::create([
        'user_id' => Auth::id(),
        'order_number' => 'ORD-' . strtoupper(Str::random(10)),
        'address' => $request->address,
        'postal_code' => $request->postal_code,
        'subtotal' => $subtotal,
        'shipping_price' => $shippingPrice,
        'total_price' => $total,
        'status' => 'pending',
    ]);

    // Buat Order Items
    foreach ($carts as $cart) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
            'price' => $cart->product->price,
        ]);
    }

    // Hapus cart setelah checkout
    Cart::where('user_id', Auth::id())->delete();

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