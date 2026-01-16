<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = TicketCategory::all();
        return view('customer.pages.tiket.index', compact('tickets'));
    }

    // 1. Simpan Order Sementara & Arahkan ke Pembayaran
    public function checkout(Request $request)
    {
        $request->validate([
            'visit_date' => 'required|date|after:today',
            'tickets' => 'required|array',
        ]);

        $totalPrice = 0;
        $totalTicket = 0;
        $categoryId = null;

        // Hitung total manual agar aman dari manipulasi frontend
        foreach ($request->tickets as $id => $qty) {
            if ($qty > 0) {
                $ticket = TicketCategory::findOrFail($id);
                $totalPrice += $ticket->price * $qty;
                $totalTicket += $qty;
                $categoryId = $id; // Ambil salah satu kategori untuk simplifikasi relasi
            }
        }

        if ($totalTicket == 0) {
            return back()->withErrors('Silakan pilih minimal 1 tiket.');
        }

        // Simpan Transaksi status PENDING
        $transaction = TicketTransaction::create([
            'user_id' => Auth::id(),
            'ticket_category_id' => $categoryId,
            'transaction_code' => 'INV-TKT-' . strtoupper(Str::random(10)),
            'visit_date' => $request->visit_date,
            'total_ticket' => $totalTicket,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // Redirect ke halaman pilih metode pembayaran
        return redirect()->route('tiket.payment', $transaction->id);
    }

    // 2. Halaman Pilih Metode Pembayaran
    public function payment($id)
    {
        $transaction = TicketTransaction::where('user_id', Auth::id())->findOrFail($id);
        return view('customer.pages.tiket.payment', compact('transaction'));
    }

    // 3. Proses Bayar (Simulasi) -> Redirect ke Profile & Buka Invoice
    public function processPayment(Request $request, $id)
    {
        $transaction = TicketTransaction::where('user_id', Auth::id())->findOrFail($id);

        // Update Status jadi PAID
        $transaction->update([
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'payment_proof' => 'dummy-proof.jpg', // Nanti diganti upload file asli
        ]);

        // Redirect ke Profile dengan membawa ID Invoice agar Pop-up terbuka otomatis
        return redirect()->route('profile.index')->with('show_invoice', $transaction->id);
    }
}