<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;

class TicketManagementController extends Controller
{
    public function index()
    {
        // Ambil kategori untuk diatur harganya
        $categories = TicketCategory::all();

        // Ambil riwayat transaksi tiket untuk laporan
        $ticketSales = TicketTransaction::with(['user', 'ticketCategory'])->latest()->get();

        return view('admin.tickets.index', compact('categories', 'ticketSales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['price' => 'required|numeric']);

        $category = TicketCategory::findOrFail($id);
        $category->update(['price' => $request->price]);

        return back()->with('success', 'Harga tiket berhasil diperbarui.');
    }
}