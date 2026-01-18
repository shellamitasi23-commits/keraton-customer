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
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Get all products with latest first
            $products = Product::orderBy('created_at', 'desc')->get();

            // Get shop sales with relationships
            $shopSales = Order::with(['user', 'items.product'])
                ->where('status', 'paid')
                ->latest()
                ->get();

            // Log for debugging
            Log::info('Shop Management Index', [
                'products_count' => $products->count(),
                'sales_count' => $shopSales->count()
            ]);

            return view('admin.shop.index', compact('products', 'shopSales'));

        } catch (Exception $e) {
            Log::error('Error loading shop management index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999999',
            'stock' => 'required|integer|min:0|max:999999',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi',
            'description.required' => 'Deskripsi produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'stock.required' => 'Stok produk harus diisi',
            'stock.integer' => 'Stok harus berupa angka bulat',
            'image.required' => 'Foto produk harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store image
                $imagePath = $image->storeAs('products', $filename, 'public');

                Log::info('Image uploaded successfully', [
                    'path' => $imagePath,
                    'filename' => $filename
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
                'name' => $product->name
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete uploaded image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
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
     * Update the specified resource in storage.
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama produk harus diisi',
            'description.required' => 'Deskripsi produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'stock.required' => 'Stok produk harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
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

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store new image
                $data['image'] = $image->storeAs('products', $filename, 'public');

                Log::info('New image uploaded for product update', [
                    'product_id' => $id,
                    'new_path' => $data['image']
                ]);
            }

            // Update product
            $product->update($data);

            // Delete old image if new image was uploaded
            if ($request->hasFile('image') && $oldImagePath) {
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                    Log::info('Old image deleted', ['path' => $oldImagePath]);
                }
            }

            DB::commit();

            Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'name' => $product->name
            ]);

            return redirect()
                ->route('admin.shop.index')
                ->with('success', 'Produk "' . $product->name . '" berhasil diperbarui!');

        } catch (Exception $e) {
            DB::rollBack();

            // Delete new uploaded image if exists and update failed
            if (isset($data['image']) && Storage::disk('public')->exists($data['image'])) {
                Storage::disk('public')->delete($data['image']);
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {
            // Check if product has any orders
            $hasOrders = OrderItem::where('product_id', $id)->exists();

            if ($hasOrders) {
                Log::warning('Attempted to delete product with orders', [
                    'product_id' => $id,
                    'product_name' => $product->name
                ]);

                return redirect()
                    ->route('admin.shop.index')
                    ->with('error', 'Tidak dapat menghapus produk "' . $product->name . '" karena sudah memiliki riwayat transaksi!');
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
}