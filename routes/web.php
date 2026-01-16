<?php

use Illuminate\Support\Facades\Route;

// Import Semua Controller
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

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

// Halaman Utama & Informasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/museum', [MuseumController::class, 'index'])->name('museum');
Route::get('/tiket', [TicketController::class, 'index'])->name('tiket.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Proses Autentikasi tetap menggunakan POST
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. PROTECTED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
| Semua route di dalam group ini otomatis dicek apakah user sudah login.
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

/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (Hanya Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Laporan
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

    // CRUD Resources
    Route::get('/museum', [MuseumManagementController::class, 'index'])->name('museum.index');
    Route::post('/museum', [MuseumManagementController::class, 'store'])->name('museum.store');
    Route::delete('/museum/{museum}', [MuseumManagementController::class, 'destroy'])->name('museum.destroy');
    Route::put('/museum/{museum}', [MuseumManagementController::class, 'update'])->name('museum.update');
    
    Route::resource('tickets', TicketManagementController::class);

    Route::resource('shop', ShopManagementController::class);
});