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
    // Total tiket terjual
    $totalTickets = TicketTransaction::count();

    // Pendapatan Merchandise - PERBAIKI INI
     $merchRevenue = Order::sum('total_price');

    // Total users (sudah benar)
    $totalUsers = User::count();

    // Data untuk chart
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