<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketTransaction;
use App\Models\Order;

class ReportController extends Controller
{
    public function index()
    {
        // Ambil laporan penjualan tiket
        $ticketSales = TicketTransaction::with('user')->latest()->get();
        // Ambil laporan penjualan merchandise
        $shopSales = Order::with('user')->latest()->get();

        return view('admin.dashboard', compact('ticketSales', 'shopSales'));
    }
}