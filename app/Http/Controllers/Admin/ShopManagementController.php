<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ShopManagementController extends Controller
{
    /**
     * Display a listing of the resource (OPTIMIZED)
     * 
     * Perbaikan:
     * - Limit data sales yang ditampilkan
     * - Hanya load relasi yang dibutuhkan
     * - Bisa ditambahkan pagination
     */
    public function index()
    {
        try {
            // Get all products with latest first
            $products = Product::select([
                'id',
                'name',
                'description',
                'price',
                'stock',
                'image',
                'created_at',
                'updated_at'
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            // Get shop sales - LIMIT untuk performa
            // Hanya ambil 50 transaksi terakhir, sisanya bisa pakai pagination
            $shopSales = Order::with([
                'user:id,name,email', // Hanya ambil kolom yang dibutuhkan
                'items:id,order_id,product_id,quantity,price', // Hanya ambil kolom yang dibutuhkan
                'items.product:id,name,image' // Hanya ambil kolom yang dibutuhkan
            ])
                ->select([
                    'id',
                    'user_id',
                    'order_number',
                    'total_price',
                    'status',
                    'payment_method',
                    'created_at'
                ])
                ->where('status', 'paid')
                ->latest()
                ->limit(50) // PENTING: Batasi data untuk performa
                ->get();

            // Calculate statistics
            $totalRevenue = $shopSales->sum('total_price');
            $totalOrders = $shopSales->count();
            $totalProducts = $products->count();
            $lowStockProducts = $products->where('stock', '<', 10)->count();

            Log::info('Shop Management Index', [
                'products_count' => $totalProducts,
                'sales_count' => $totalOrders,
                'low_stock_count' => $lowStockProducts
            ]);

            return view('admin.shop.index', compact(
                'products',
                'shopSales',
                'totalRevenue',
                'totalOrders',
                'totalProducts',
                'lowStockProducts'
            ));

        } catch (Exception $e) {
            Log::error('Error loading shop management index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage (OPTIMIZED)
     * 
     * Perbaikan:
     * - Validasi lebih ketat
     * - Error handling lebih baik
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi',
            'description.required' => 'Deskripsi produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh kurang dari 0',
            'stock.required' => 'Stok produk harus diisi',
            'stock.integer' => 'Stok harus berupa angka bulat',
            'stock.min' => 'Stok tidak boleh kurang dari 0',
            'image.required' => 'Foto produk harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate unique filename dengan timestamp
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store image
                $imagePath = $image->storeAs('products', $filename, 'public');

                Log::info('Image uploaded successfully', [
                    'path' => $imagePath,
                    'filename' => $filename,
                    'size' => $image->getSize()
                ]);
            }

            // Create product
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'image' => $imagePath,
            ]);

            DB::commit();

            Log::info('Product created successfully', [
                'product_id' => $product->id,
                'name' => $product->name,
                'stock' => $product->stock,
                'price' => $product->price
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete uploaded image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info('Rolled back - image deleted', ['path' => $imagePath]);
            }

            Log::error('Error creating product', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage (OPTIMIZED)
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi',
            'description.required' => 'Deskripsi produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'price.min' => 'Harga tidak boleh kurang dari 0',
            'stock.required' => 'Stok produk harus diisi',
            'stock.min' => 'Stok tidak boleh kurang dari 0',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ];

            $oldImagePath = $product->image;
            $newImagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate unique filename
                $filename = 'product_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store new image
                $newImagePath = $image->storeAs('products', $filename, 'public');
                $data['image'] = $newImagePath;

                Log::info('New image uploaded for product update', [
                    'product_id' => $id,
                    'new_path' => $newImagePath,
                    'old_path' => $oldImagePath
                ]);
            }

            // Update product
            $product->update($data);

            // Delete old image only after successful update
            if ($newImagePath && $oldImagePath && $oldImagePath !== $newImagePath) {
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                    Log::info('Old image deleted after successful update', ['path' => $oldImagePath]);
                }
            }

            DB::commit();

            Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'name' => $product->name,
                'changes' => $product->getChanges()
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('success', 'Produk "' . $product->name . '" berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete new uploaded image if exists and update failed
            if ($newImagePath && Storage::disk('public')->exists($newImagePath)) {
                Storage::disk('public')->delete($newImagePath);
                Log::info('Rolled back - new image deleted', ['path' => $newImagePath]);
            }

            Log::error('Error updating product', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage (OPTIMIZED)
     * 
     * Perbaikan:
     * - Cek relasi dengan order items
     * - Soft delete bisa dipertimbangkan untuk data historis
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {
            // Check if product has any orders
            $orderCount = OrderItem::where('product_id', $id)->count();

            if ($orderCount > 0) {
                Log::warning('Attempted to delete product with orders', [
                    'product_id' => $id,
                    'product_name' => $product->name,
                    'order_count' => $orderCount
                ]);

                DB::rollBack();

                return redirect()
                    ->route('admin.shop.index')
                    ->with('error', 'Tidak dapat menghapus produk "' . $product->name . '" karena sudah memiliki ' . $orderCount . ' transaksi!');
            }

            // Check if product is in any cart
            $cartCount = \App\Models\Cart::where('product_id', $id)->count();
            if ($cartCount > 0) {
                // Hapus dari cart juga
                \App\Models\Cart::where('product_id', $id)->delete();
                Log::info('Removed product from carts', [
                    'product_id' => $id,
                    'cart_count' => $cartCount
                ]);
            }

            $productName = $product->name;
            $imagePath = $product->image;

            // Delete product
            $product->delete();

            // Delete image file
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                Log::info('Product image deleted', ['path' => $imagePath]);
            }

            DB::commit();

            Log::info('Product deleted successfully', [
                'product_id' => $id,
                'name' => $productName
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('success', 'Produk "' . $productName . '" berhasil dihapus!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting product', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * BONUS: Method untuk update status order (jika belum ada)
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled'
        ]);

        try {
            $order = Order::findOrFail($orderId);
            $oldStatus = $order->status;

            $order->update(['status' => $request->status]);

            Log::info('Order status updated', [
                'order_id' => $orderId,
                'old_status' => $oldStatus,
                'new_status' => $request->status
            ]);

            return back()->with('success', 'Status order berhasil diupdate!');

        } catch (Exception $e) {
            Log::error('Error updating order status', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal update status order!');
        }
    }
}