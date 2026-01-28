<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        // Ambil semua kategori tiket dengan foto
        $tickets = TicketCategory::all();
        return view('customer.pages.tiket.index', compact('tickets'));
    }

    // 1. Simpan Order Sementara & Arahkan ke Pembayaran
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date|after:today',
            'tickets' => 'required|array|min:1',
            'tickets.*' => 'integer|min:0',
        ]);

        $totalPrice = 0;
        $totalTicket = 0;
        $ticketDetails = [];
        $firstCategoryId = null;

        DB::beginTransaction();
        try {
            foreach ($validated['tickets'] as $categoryId => $qty) {
                if ($qty > 0) {
                    $ticket = TicketCategory::findOrFail($categoryId);

                    $subtotal = $ticket->price * $qty;
                    $totalPrice += $subtotal;
                    $totalTicket += $qty;

                    $ticketDetails[] = [
                        'category_id' => $categoryId,
                        'category_name' => $ticket->name,
                        'price' => $ticket->price,
                        'quantity' => $qty,
                        'subtotal' => $subtotal,
                        'image' => $ticket->image,
                    ];

                    if ($firstCategoryId === null) {
                        $firstCategoryId = $categoryId;
                    }
                }
            }

            if ($totalTicket == 0) {
                return back()->withErrors(['tickets' => 'Silakan pilih minimal 1 tiket.'])->withInput();
            }

            $transaction = TicketTransaction::create([
                'user_id' => Auth::id(),
                'ticket_category_id' => $firstCategoryId,
                'transaction_code' => 'INV-TKT-' . strtoupper(Str::random(10)),
                'visit_date' => $validated['visit_date'],
                'total_ticket' => $totalTicket,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'ticket_details' => json_encode($ticketDetails), // Jika field ini ada
            ]);

            DB::commit();

            return redirect()->route('tiket.payment', $transaction->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // 2. Halaman Pilih Metode Pembayaran
    public function payment($id)
    {
        $transaction = TicketTransaction::where('user_id', Auth::id())
            ->with('ticketCategory')
            ->findOrFail($id);

        // Decode ticket details jika field ada
        $ticketDetails = null;
        if ($transaction->ticket_details) {
            $ticketDetails = json_decode($transaction->ticket_details, true);
        }

        return view('customer.pages.tiket.payment', compact('transaction', 'ticketDetails'));
    }

    // 3. Proses Bayar -> Redirect ke Profile & Buka Invoice
    public function processPayment(Request $request, $id)
    {
        // ✅ FIX: Sesuaikan validasi dengan value di form HTML
        $validated = $request->validate([
            'payment_method' => 'required|in:qris,transfer', // Sesuaikan dengan form!
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $transaction = TicketTransaction::where('user_id', Auth::id())->findOrFail($id);

            // Cek jika sudah paid
            if ($transaction->status === 'paid') {
                return redirect()->route('profile.index')
                    ->with('error', 'Transaksi ini sudah dibayar!');
            }

            $paymentProof = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProof = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            // Update data (hanya field yang ada di database)
            $updateData = [
                'status' => 'paid',
                'payment_method' => $validated['payment_method'],
            ];

            // Tambahkan field optional jika ada
            if ($paymentProof) {
                $updateData['payment_proof'] = $paymentProof;
            }

            // Cek apakah kolom paid_at ada di database
            if (\Schema::hasColumn('ticket_transactions', 'paid_at')) {
                $updateData['paid_at'] = now();
            }

            $transaction->update($updateData);

            DB::commit();

            // Redirect ke Profile dengan session untuk trigger popup invoice
            return redirect()->route('profile.index')
                ->with('show_invoice', $transaction->id)
                ->with('success', 'Pembayaran berhasil! Tiket Anda sudah aktif.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Pembayaran gagal: ' . $e->getMessage());
        }
    }
}