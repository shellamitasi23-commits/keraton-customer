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
| 1. CUSTOMER HOME & AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('customer.home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/museum', [MuseumController::class, 'index'])->name('museum');
Route::get('/tiket', [TicketController::class, 'index'])->name('tiket.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

/*
|--------------------------------------------------------------------------
| 2. CUSTOMER PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/tiket/checkout', [TicketController::class, 'checkout'])->name('tiket.order');
    Route::get('/tiket/payment/{id}', [TicketController::class, 'payment'])->name('tiket.payment');
    Route::post('/tiket/payment/{id}', [TicketController::class, 'processPayment'])->name('tiket.process');

    Route::post('/shop/add/{id}', [ShopController::class, 'addToCart'])->name('shop.add');
    Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::patch('/cart/{id}/update', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}', [ShopController::class, 'deleteCart'])->name('shop.delete');

    Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('shop.processCheckout');

    Route::get('/shop/payment/{id}', [ShopController::class, 'payment'])->name('shop.payment');
    Route::post('/shop/payment/{id}', [ShopController::class, 'processPayment'])->name('shop.pay');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES - FIX: Hapus nested prefix admin
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ FIX: Museum Management - Hapus prefix('admin') yang dobel
    Route::prefix('museum')->name('museum.')->group(function () {
        Route::get('/', [MuseumManagementController::class, 'index'])->name('index');
        Route::post('/', [MuseumManagementController::class, 'store'])->name('store');
        Route::put('/{museum}', [MuseumManagementController::class, 'update'])->name('update');
        Route::delete('/{museum}', [MuseumManagementController::class, 'destroy'])->name('destroy');
    });

    // Kelola Tiket
    Route::get('/tickets', [TicketManagementController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketManagementController::class, 'store'])->name('tickets.store');
    Route::put('/tickets/{id}', [TicketManagementController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketManagementController::class, 'destroy'])->name('tickets.destroy');

    // Kelola Shop
// Shop Management Routes
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/', [ShopManagementController::class, 'index'])->name('index');
        Route::post('/', [ShopManagementController::class, 'store'])->name('store');
        Route::put('/{id}', [ShopManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [ShopManagementController::class, 'destroy'])->name('destroy');
    });

    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'downloadPDF'])->name('reports.download');

    // Logout Admin
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
});

// Refresh CSRF Token
Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});