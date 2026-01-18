<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * ========================================
     * CUSTOMER LOGIN - MENGGUNAKAN EMAIL
     * ========================================
     */

    /**
     * Tampilkan form login customer (email)
     */
    public function showLoginForm()
    {
        // Karena login customer pakai modal di homepage, arahkan ke home jika diakses manual
        return redirect()->route('customer.home');
    }

    public function showRegisterForm()
    {
        return redirect()->route('customer.home');
    }

    /**
     * Proses login customer dengan email
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password wajib diisi',
        ]);

        // Pastikan user adalah customer, bukan admin
        $user = User::firstWhere('email', $credentials['email']);
        if ($user && $user->role === 'admin') {
            return back()->withErrors(['email' => 'Akses ditolak. Silakan login di halaman admin.'])->withInput();
        }

        // Attempt login dengan guard 'web'
        if (Auth::guard('web')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.home'))->with('success', 'Berhasil login!');
        }

        return back()->withErrors(['password' => 'Password salah'])->withInput();
    }

    /**
     * Proses Register (Untuk Customer)
     */
   // --- Bagian Register di AuthController.php ---
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'email_verified_at' => now(), // Auto verify
        ]);

        // Auto login setelah register
        Auth::guard('web')->login($user);

        // Redirect ke home dengan session success
        return redirect()->route('customer.home')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
    }

    /**
     * ========================================
     * ADMIN LOGIN - MENGGUNAKAN USERNAME
     * ========================================
     */

    /**
     * Tampilkan form login admin (username)
     */
    public function showAdminLoginForm()
    {
        // Pastikan guard 'admin' sudah terdefinisi di config/auth.php sebelum ini dipanggil
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Pastikan view ini ada sesuai struktur folder Anda
        return view('admin.auth.login');
    }

    /**
     * Proses login admin dengan username
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        \Log::info('Attempt login:', ['username' => $credentials['username']]);

        $user = \App\Models\User::where('username', $credentials['username'])->first();

        if (!$user) {
            \Log::warning('User not found:', ['username' => $credentials['username']]);
            return back()->withErrors(['username' => 'Username tidak ditemukan.']);
        }

        \Log::info('User found:', ['username' => $user->username, 'role' => $user->role]);

        if ($user->role !== 'admin') {
            \Log::warning('User is not admin:', ['username' => $user->username]);
            return back()->withErrors(['username' => 'Anda bukan admin.']);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            \Log::info('Login successful:', ['username' => $user->username]);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        \Log::warning('Password incorrect:', ['username' => $credentials['username']]);
        return back()->withErrors(['password' => 'Password salah.']);
    }

    /**
     * ========================================
     * LOGOUT
     * ========================================
     */

    /**
     * Logout customer
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('customer.home'))->with('success', 'Berhasil logout!');
    }

    /**
     * Logout admin
     */
    public function adminLogout(Request $request)
    {
        // Pastikan hanya logout guard admin
        Auth::guard('admin')->logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke login admin
        return redirect()->route('admin.login')->with('success', 'Berhasil logout!');
    }
}