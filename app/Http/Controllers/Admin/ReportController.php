<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketTransaction;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf; // Import library PDF

class ReportController extends Controller
{
    public function index()
    {
        $ticketTransactions = TicketTransaction::with(['user', 'ticketCategory'])->latest()->get();
        $merchandiseOrders = Order::with('user')->latest()->get();

        return view('admin.reports.index', compact('ticketTransactions', 'merchandiseOrders'));
    }

    public function downloadPDF()
    {
        $ticketTransactions = TicketTransaction::with(['user', 'ticketCategory'])->latest()->get();
        $merchandiseOrders = Order::with('user')->latest()->get();

        // Mengarahkan ke view khusus cetak
        $pdf = Pdf::loadView('admin.reports.export_pdf', compact('ticketTransactions', 'merchandiseOrders'));

        // Download file dengan nama tertentu
        return $pdf->download('laporan-keraton-' . date('Y-m-d') . '.pdf');
    }
}