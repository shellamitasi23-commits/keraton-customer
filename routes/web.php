<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MuseumController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MuseumManagementController;
use App\Http\Controllers\Admin\TicketManagementController;
use App\Http\Controllers\Admin\ShopManagementController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| 1. CUSTOMER HOME & AUTHENTICATION ROUTES (Akses Umum)
|--------------------------------------------------------------------------
*/

// Halaman Utama untuk Customer (Akses Umum)
Route::get('/', [HomeController::class, 'index'])->name('customer.home');

// Rute Login Customer (Email)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rute Registrasi Customer
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rute Login Admin (Username)
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

// Halaman Informasi Publik
Route::get('/museum', [MuseumController::class, 'index'])->name('museum');
Route::get('/tiket', [TicketController::class, 'index'])->name('tiket.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

/*
|--------------------------------------------------------------------------
| 2. CUSTOMER PROTECTED ROUTES (Perlu Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // --- A. Transaksi Tiket ---
    Route::post('/tiket/checkout', [TicketController::class, 'checkout'])->name('tiket.order');
    Route::get('/tiket/payment/{id}', [TicketController::class, 'payment'])->name('tiket.payment');
    Route::post('/tiket/payment/{id}', [TicketController::class, 'processPayment'])->name('tiket.process');


    // --- B. Transaksi Merchandise (Shop) ---

    // Keranjang Belanja
    Route::post('/shop/add/{id}', [ShopController::class, 'addToCart'])->name('shop.add');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    // Tambahkan di dalam middleware auth group, setelah route shop.delete
    Route::patch('/cart/{id}/update', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}', [ShopController::class, 'deleteCart'])->name('shop.delete');

    // Checkout Barang (Alamat)
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('shop.processCheckout');

    // Pembayaran Barang
    Route::get('/shop/payment/{id}', [ShopController::class, 'payment'])->name('shop.payment');
    Route::post('/shop/payment/{id}', [ShopController::class, 'processPayment'])->name('shop.pay');


    // --- C. User Profile ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Museum
    Route::get('/museum', [MuseumManagementController::class, 'index'])->name('museum.index');
    Route::post('/museum', [MuseumManagementController::class, 'store'])->name('museum.store');
    Route::put('/museum/{museum}', [MuseumManagementController::class, 'update'])->name('museum.update');
    Route::delete('/museum/{museum}', [MuseumManagementController::class, 'destroy'])->name('museum.destroy');

    // Kelola Tiket
    Route::get('/tickets', [TicketManagementController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketManagementController::class, 'store'])->name('tickets.store');
    Route::put('/tickets/{id}', [TicketManagementController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketManagementController::class, 'destroy'])->name('tickets.destroy');

    // Kelola Shop - Full CRUD
    Route::get('/shop', [ShopManagementController::class, 'index'])->name('shop.index');
    Route::post('/shop', [ShopManagementController::class, 'store'])->name('shop.store');
    Route::put('/shop/{id}', [ShopManagementController::class, 'update'])->name('shop.update');
    Route::delete('/shop/{id}', [ShopManagementController::class, 'destroy'])->name('shop.destroy');

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'downloadPDF'])->name('reports.download');
});