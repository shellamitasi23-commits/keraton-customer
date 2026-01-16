<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ShopManagementController extends Controller
{
    public function index()
    {
        // Mengambil semua produk merchandise
        $products = Product::all();

        // Mengambil laporan penjualan dari tabel orders
        $shopSales = Order::with('user')->latest()->get();

        return view('admin.shop.index', compact('products', 'shopSales'));
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['stock' => $request->stock]);

        return back()->with('success', 'Stok berhasil diperbarui.');
    }
}