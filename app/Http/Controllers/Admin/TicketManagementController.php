<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = TicketCategory::all();

        $ticketSales = TicketTransaction::with(['user', 'ticketCategory'])
            ->where('status', 'paid')
            ->latest()
            ->get();

        return view('admin.tickets.index', compact('categories', 'ticketSales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ubah jadi required sesuai form
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('tickets', 'public');
            }

            TicketCategory::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.tickets.index')
                ->with('success', 'Kategori tiket berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = TicketCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = $category->image;

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                $imagePath = $request->file('image')->store('tickets', 'public');
            }

            $category->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'image' => $imagePath,
            ]);

            return redirect()->route('admin.tickets.index')
                ->with('success', 'Kategori tiket berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = TicketCategory::findOrFail($id);

            // Cek apakah kategori ini punya transaksi
            $hasTransactions = TicketTransaction::where('ticket_category_id', $id)->exists();

            if ($hasTransactions) {
                return redirect()->route('admin.tickets.index')
                    ->with('error', 'Tidak dapat menghapus kategori yang sudah memiliki transaksi!');
            }

            // Hapus gambar dari storage jika ada
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return redirect()->route('admin.tickets.index')
                ->with('success', 'Kategori tiket berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}