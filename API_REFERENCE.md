# 📖 API Reference & Method Documentation

## AuthController Methods

### Customer Authentication

#### `showLoginForm()`

**Purpose**: Menampilkan halaman login customer  
**Guard**: Tidak ada (halaman publik)  
**Route**: `GET /login`  
**View**: `auth.customer-login`  
**Return**:

- Jika sudah login → redirect ke `customer.home`
- Jika belum → tampilkan form login

```php
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
```

---

#### `login(Request $request)`

**Purpose**: Proses login customer dengan email  
**Guard**: `web`  
**Route**: `POST /login`  
**Parameters**:

```php
[
    'email' => 'required|email|exists:users,email',
    'password' => 'required|string|min:6',
    'remember' => 'optional' // checkbox untuk "remember me"
]
```

**Validasi Tambahan**:

- Cek bahwa user role bukan `admin`

**Return**:

- Success → redirect ke `customer.home` dengan message "Berhasil login!"
- Error (email tidak terdaftar) → back dengan error
- Error (password salah) → back dengan error "Password salah"
- Error (user adalah admin) → back dengan error "Akses ditolak..."

---

#### `showRegisterForm()`

**Purpose**: Menampilkan halaman registrasi customer  
**Guard**: Tidak ada (halaman publik)  
**Route**: `GET /register`  
**View**: `auth.customer-register`  
**Return**:

- Jika sudah login → redirect ke `customer.home`
- Jika belum → tampilkan form registrasi

```php
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
```

---

#### `register(Request $request)`

**Purpose**: Proses registrasi customer baru  
**Guard**: Tidak ada  
**Route**: `POST /register`  
**Parameters**:

```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|unique:users',
    'phone' => 'optional|string',
    'password' => 'required|string|min:6|confirmed',
    'password_confirmation' => 'required'
]
```

**Return**:

- Success → redirect ke login page dengan message "Registrasi berhasil, silakan login."
- Error (validation) → back dengan error messages

**Database Effect**:

- Buat user baru dengan `role = 'customer'`
- Password di-hash otomatis
- Email di-verify nanti (optional)

---

### Admin Authentication

#### `showAdminLoginForm()`

**Purpose**: Menampilkan halaman login admin  
**Guard**: Tidak ada (halaman publik)  
**Route**: `GET /admin/login`  
**View**: `auth.admin-login`  
**Return**:

- Jika sudah login as admin → redirect ke `admin.dashboard`
- Jika belum → tampilkan form login admin

```php
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
```

---

#### `adminLogin(Request $request)`

**Purpose**: Proses login admin dengan username  
**Guard**: `admin`  
**Route**: `POST /admin/login`  
**Parameters**:

```php
[
    'username' => 'required|string|exists:users,username',
    'password' => 'required|string|min:6',
    'remember' => 'optional'
]
```

**Validasi Tambahan**:

- Cek bahwa user role adalah `admin`

**Return**:

- Success → redirect ke `admin.dashboard` dengan message "Selamat datang Admin!"
- Error (username tidak ditemukan) → back dengan error
- Error (password salah) → back dengan error "Password salah"
- Error (user bukan admin) → back dengan error "User ini bukan admin..."

---

### Logout

#### `logout(Request $request)`

**Purpose**: Logout customer  
**Guard**: `web`  
**Route**: `POST /logout`  
**Middleware**: `auth` (otomatis)

```php
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
```

**Effect**:

- `Auth::guard('web')->logout()` - Destroy session
- `$request->session()->invalidate()` - Invalidate semua session
- `$request->session()->regenerateToken()` - Regenerate CSRF token
- Redirect ke `customer.home` dengan message "Berhasil logout!"

---

#### `adminLogout(Request $request)`

**Purpose**: Logout admin  
**Guard**: `admin`  
**Route**: `POST /admin/logout`  
**Middleware**: `admin` (custom)

```php
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');
```

**Effect**:

- `Auth::guard('admin')->logout()` - Destroy session
- `$request->session()->invalidate()` - Invalidate semua session
- `$request->session()->regenerateToken()` - Regenerate CSRF token
- Redirect ke `admin.login` dengan message "Berhasil logout!"

---

## Route Reference

### Public Routes (Tanpa Authentication)

```php
GET  /                        → HomeController@index        (name: customer.home)
GET  /login                   → AuthController@showLoginForm (name: login)
POST /login                   → AuthController@login
GET  /register                → AuthController@showRegisterForm (name: register.form)
POST /register                → AuthController@register (name: register)
GET  /admin/login             → AuthController@showAdminLoginForm (name: admin.login)
POST /admin/login             → AuthController@adminLogin
```

### Customer Protected Routes (Guard: `web`)

```php
POST /logout                  → AuthController@logout (name: logout)
POST /tiket/checkout          → TicketController@checkout (name: tiket.order)
GET  /tiket/payment/{id}      → TicketController@payment (name: tiket.payment)
POST /tiket/payment/{id}      → TicketController@processPayment (name: tiket.process)
... (lihat routes/web.php untuk lengkapnya)
```

### Admin Protected Routes (Middleware: `admin`)

```php
GET  /admin/dashboard         → DashboardController@index (name: admin.dashboard)
GET  /admin/reports           → ReportController@index (name: admin.reports.index)
GET  /admin/museum            → MuseumManagementController@index (name: admin.museum.index)
... (admin resource routes)
POST /admin/logout            → AuthController@adminLogout (name: admin.logout)
```

---

## Middleware Reference

### `IsAdmin` Middleware

**File**: `app/Http/Middleware/IsAdmin.php`  
**Alias**: `admin`  
**Purpose**: Protect routes yang hanya boleh diakses admin

**Validation**:

```php
// Cek bahwa:
1. User logged in dengan guard 'admin' (bukan 'web')
2. User role adalah 'admin'
```

**Redirect**: Jika gagal → `admin.login` dengan error "Silakan login sebagai admin..."

**Usage in Routes**:

```php
Route::middleware(['admin'])->group(function() {
    // Hanya admin dengan username+password yang bisa akses
});
```

---

## Guard & Provider Reference

### Guard: `web`

- **Driver**: `session`
- **Provider**: `users`
- **Purpose**: Customer login dengan email
- **Session Key**: `login_web_[hash]`

### Guard: `admin`

- **Driver**: `session`
- **Provider**: `admin`
- **Purpose**: Admin login dengan username
- **Session Key**: `login_admin_[hash]`

---

## Facade Usage

### Check Authentication

```php
// Customer
Auth::guard('web')->check()              // true/false
Auth::guard('web')->id()                 // user ID
Auth::guard('web')->user()               // User object
Auth::guard('web')->user()->email        // Email address

// Admin
Auth::guard('admin')->check()            // true/false
Auth::guard('admin')->id()               // user ID
Auth::guard('admin')->user()             // User object
Auth::guard('admin')->user()->username   // Username
```

### Attempt Login

```php
// Customer
Auth::guard('web')->attempt(['email' => $email, 'password' => $password]);

// Admin
Auth::guard('admin')->attempt(['username' => $username, 'password' => $password]);
```

### Manual Login

```php
// Customer
$user = User::findOrFail($id);
Auth::guard('web')->login($user);

// Admin
$admin = User::findOrFail($id);
Auth::guard('admin')->login($admin);
```

### Logout

```php
Auth::guard('web')->logout();
Auth::guard('admin')->logout();
```

---

## Error Handling

### Validation Errors

```php
'email.required' => 'Email wajib diisi'
'email.email' => 'Format email tidak valid'
'email.exists' => 'Email tidak terdaftar'
'password.required' => 'Password wajib diisi'
'username.required' => 'Username wajib diisi'
'username.exists' => 'Username tidak ditemukan'
```

### Custom Errors

```php
'Akses ditolak. Silakan login di halaman admin.'
'User ini bukan admin. Akses ditolak.'
'Password salah'
```

---

## Database Queries Reference

### Create User (Customer)

```php
User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => Hash::make($request->password),
    'role' => 'customer',
]);
```

### Find User by Email

```php
$user = User::firstWhere('email', $email);
```

### Find User by Username

```php
$admin = User::firstWhere('username', $username);
```

### Update User

```php
$user->update([
    'phone' => $phone,
    'password' => Hash::make($newPassword),
]);
```

---

## View Blade Reference

### Check Customer Logged In

```blade
@if (Auth::guard('web')->check())
    <p>Welcome {{ Auth::guard('web')->user()->name }}</p>
@else
    <a href="{{ route('login') }}">Login</a>
@endif
```

### Check Admin Logged In

```blade
@if (Auth::guard('admin')->check())
    <p>Admin: {{ Auth::guard('admin')->user()->name }}</p>
@else
    <a href="{{ route('admin.login') }}">Admin Login</a>
@endif
```

### Form CSRF Token

```blade
<form method="POST" action="/login">
    @csrf
    <!-- input fields -->
</form>
```

### Display Errors

```blade
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
@endif

@error('email')
    <span>{{ $message }}</span>
@enderror
```

---

## Environment Variables

Tidak ada ENV variable spesifik yang perlu dikonfigurasi untuk sistem login ini.  
Pastikan `.env` memiliki:

```
APP_NAME=Keraton
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
SESSION_DRIVER=file
```

---

**Documentation Version**: 1.0  
**Last Updated**: January 17, 2026  
**Status**: ✅ Complete
