<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketTransaction;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total untuk angka di atas
        $totalTickets = TicketTransaction::count();
        $merchRevenue = Order::where('status', 'success')->sum('total_price');
        $totalUsers = User::count();

        // Data Statis untuk Grafik Kunjungan
        $chartLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $chartData = [120, 150, 100, 200];

        return view('admin.dashboard', compact(
            'totalTickets',
            'merchRevenue',
            'totalUsers',
            'chartLabels',
            'chartData'
        ));
    }
}