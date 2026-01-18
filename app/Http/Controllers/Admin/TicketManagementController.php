<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        TicketCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Kategori tiket berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = TicketCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Kategori tiket berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = TicketCategory::findOrFail($id);
        
        // Cek apakah kategori ini punya transaksi
        $hasTransactions = TicketTransaction::where('ticket_category_id', $id)->exists();
        
        if ($hasTransactions) {
            return redirect()->route('admin.tickets.index')
                             ->with('error', 'Tidak dapat menghapus kategori yang sudah memiliki transaksi!');
        }

        $category->delete();

        return redirect()->route('admin.tickets.index')
                         ->with('success', 'Kategori tiket berhasil dihapus!');
    }
}