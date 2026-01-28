<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ShopController extends Controller
{
    public function index()
    {
        $products = Product::select(['id', 'name', 'description', 'price', 'stock', 'image'])
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.pages.shop.index', compact('products'));
    }

    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        $quantity = $request->quantity;

        DB::beginTransaction();

        try {
            $product = Product::where('id', $id)->lockForUpdate()->firstOrFail();

            if ($product->stock < 1) {
                DB::rollBack();
                return back()->with('error', 'Produk habis!');
            }

            if ($quantity > $product->stock) {
                DB::rollBack();
                return back()->with('error', 'Stok tidak cukup!');
            }

            $cart = Cart::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->first();

            if ($cart) {
                $newQuantity = $cart->quantity + $quantity;
                if ($newQuantity > $product->stock)
                    $newQuantity = $product->stock;
                $cart->update(['quantity' => $newQuantity]);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'quantity' => $quantity,
                ]);
            }

            DB::commit();

            if ($request->input('type') === 'buy_now') {
                return redirect()->route('shop.checkout');
            }

            return back()->with('success', 'Produk masuk keranjang!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cart()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        $subtotal = $carts->sum(fn($c) => $c->product->price * $c->quantity);
        $shippingPrice = 15000;
        $total = $subtotal + $shippingPrice;

        return view('customer.pages.shop.cart', compact('carts', 'subtotal', 'shippingPrice', 'total'));
    }

    public function updateCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->update(['quantity' => $request->quantity]);
        return back();
    }

    public function deleteCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Item dihapus.');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Keranjang kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingPrice = 15000;
        $grandTotal = $subtotal + $shippingPrice;

        return view('customer.pages.shop.checkout', compact(
            'cartItems',
            'subtotal',
            'shippingPrice',
            'grandTotal'
        ));
    }

    public function processCheckout(Request $request)
    {
        // VALIDASI
        $request->validate([
            'address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:10',
            'whatsapp' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // AMBIL KERANJANG
            $carts = Cart::where('user_id', $user->id)->with('product')->get();

            if ($carts->isEmpty()) {
                DB::rollBack();
                return redirect()->route('shop.index')->with('error', 'Keranjang belanja kosong!');
            }

            // CEK STOK & HITUNG
            $subtotal = 0;
            foreach ($carts as $cart) {
                if ($cart->quantity > $cart->product->stock) {
                    DB::rollBack();
                    return back()->with('error', 'Stok "' . $cart->product->name . '" tidak cukup (Sisa: ' . $cart->product->stock . ')');
                }
                $subtotal += $cart->product->price * $cart->quantity;
            }

            $shippingPrice = 15000;
            $grandTotal = $subtotal + $shippingPrice;

            // BUAT ORDER - SESUAI STRUKTUR DATABASE
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'INV-' . strtoupper(Str::random(8)) . '-' . time(),
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'whatsapp' => $request->whatsapp,
                'subtotal' => $subtotal,
                'shipping_price' => $shippingPrice,
                'total_price' => $grandTotal,
                'status' => 'pending',
            ]);

            // PINDAHKAN ITEM & KURANGI STOK
            foreach ($carts as $cart) {
                $itemSubtotal = $cart->quantity * $cart->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                    'subtotal' => $itemSubtotal,
                ]);

                $cart->product->decrement('stock', $cart->quantity);
            }

            // HAPUS KERANJANG
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // REDIRECT KE HALAMAN BAYAR
            return redirect()->route('shop.payment', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function payment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status === 'paid') {
            return redirect()->route('profile.index')
                ->with('success', 'Pesanan ini sudah dibayar.');
        }

        return view('customer.pages.shop.payment', compact('order'));
    }

    public function processPayment(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        $order->update([
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_proof' => 'auto-confirmed',
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Pembayaran Berhasil! Terima kasih.');
    }
}