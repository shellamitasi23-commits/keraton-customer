# Sistem Login Terpisah: Customer (Email) & Admin (Username)

## 📋 Ringkasan Perubahan

Sistem login sekarang memiliki **2 jalur login yang berbeda**:

### 1. **Login Customer** (Email + Password)

- **Guard**: `web`
- **Provider**: `users` (default customer)
- **Kolom Login**: `email`
- **Role**: `customer`
- **Routes**:
    - GET `/login` → Tampilkan form login customer
    - POST `/login` → Proses login customer

### 2. **Login Admin** (Username + Password)

- **Guard**: `admin`
- **Provider**: `admin`
- **Kolom Login**: `username`
- **Role**: `admin`
- **Routes**:
    - GET `/admin/login` → Tampilkan form login admin
    - POST `/admin/login` → Proses login admin

---

## 🔧 File yang Diubah/Dibuat

### Migrations

- ✅ `2026_01_17_000000_add_admin_fields_to_users_table.php` - Menambah kolom `username` dan update `role` default

### Config

- ✅ `config/auth.php` - Tambah guard `admin` dan provider `admin`

### Models

- ✅ `app/Models/User.php` - Update `$fillable` untuk include `username` dan `avatar`

### Controllers

- ✅ `app/Http/Controllers/AuthController.php` - **Completely rewritten** dengan logika login terpisah

### Middleware

- ✅ `app/Http/Middleware/IsAdmin.php` - Update untuk cek guard `admin` dan role `admin`

### Routes

- ✅ `routes/web.php`:
    - Routes customer login dengan guard `web`
    - Routes admin login dengan guard `admin`
    - Admin routes protected dengan middleware `admin`

### Views

- ✅ `resources/views/auth/customer-login.blade.php` - Form login customer (email)
- ✅ `resources/views/auth/admin-login.blade.php` - Form login admin (username)

### Bootstrap

- ✅ `bootstrap/app.php` - Register middleware alias `admin`

### Seeders

- ✅ `database/seeders/AdminAndUserSeeder.php` - **Baru** - Seeder untuk admin dan customer
- ✅ `database/seeders/DatabaseSeeder.php` - Update untuk memanggil AdminAndUserSeeder

---

## 👥 Data Login Default (Setelah Seeder)

### Admin Login

```
Username: admin
Password: admin123

Username: superadmin
Password: superadmin123
```

### Customer Login (Email)

```
Email: budi@gmail.com
Password: password123

Email: siti@gmail.com
Password: password123

Email: ahmad@gmail.com
Password: password123

Email: dewi@gmail.com
Password: password123

Email: rudi@gmail.com
Password: password123
```

---

## 🚀 Cara Implementasi

### 1. Run Migration

```bash
php artisan migrate
```

### 2. Run Seeder (Opsional - untuk test data)

```bash
php artisan db:seed --class=AdminAndUserSeeder
# atau semua seeder:
php artisan db:seed
```

### 3. Test Login

**Customer Login:**

- Akses: `http://localhost/login`
- Gunakan email dan password

**Admin Login:**

- Akses: `http://localhost/admin/login`
- Gunakan username dan password

---

## 🛡️ Security Features

✅ **Password hashing** dengan `bcrypt` (otomatis dari `Authenticatable`)
✅ **Session regeneration** setelah login
✅ **Middleware protection** untuk admin routes
✅ **Role-based access control** di middleware `IsAdmin`
✅ **Validation** dengan custom error messages
✅ **Prevent admin login di customer form** dan vice versa

---

## 🔐 Flow Login

### Customer Login Flow

```
1. User input email + password di /login
2. Validate email exists (exists:users,email)
3. Cek bahwa user role bukan admin
4. Attempt login dengan guard 'web' dan kolom 'email'
5. Jika berhasil → Redirect ke customer.home
6. Jika gagal → Kembali dengan error
```

### Admin Login Flow

```
1. Admin input username + password di /admin/login
2. Validate username exists (exists:users,username)
3. Cek bahwa user role adalah admin
4. Attempt login dengan guard 'admin' dan kolom 'username'
5. Jika berhasil → Redirect ke admin.dashboard
6. Jika gagal → Kembali dengan error
```

---

## 📝 Penggunaan di Controllers

### Cek Login Customer

```php
if (Auth::guard('web')->check()) {
    // User customer sudah login
}
```

### Cek Login Admin

```php
if (Auth::guard('admin')->check()) {
    // Admin sudah login
}
```

### Get Current User/Admin

```php
$customer = Auth::guard('web')->user();
$admin = Auth::guard('admin')->user();
```

### Logout Customer

```php
Auth::guard('web')->logout();
```

### Logout Admin

```php
Auth::guard('admin')->logout();
```

---

## 📍 Route Protection

### Routes yang Memerlukan Customer Login

```php
Route::middleware(['auth'])->group(function () {
    // Routes customer protected
});
```

### Routes yang Memerlukan Admin Login

```php
Route::middleware(['admin'])->group(function () {
    // Routes admin protected
});
```

---

## ✨ Fitur Tambahan

- ✅ "Remember me" checkbox pada kedua form login
- ✅ Custom error messages (Indonesian)
- ✅ Link redirect ke halaman login lain di setiap form
- ✅ Validation untuk memastikan hanya role yang sesuai yang bisa login
- ✅ Session invalidation saat logout

---

## 🐛 Troubleshooting

### Jika migration error

```bash
php artisan migrate:fresh --seed
```

### Jika middleware tidak terdaftar

- Pastikan `bootstrap/app.php` sudah di-update dengan middleware alias
- Restart server: `php artisan serve`

### Jika view tidak ditemukan

- Pastikan file blade ada di `resources/views/auth/`
- Check nama file: `customer-login.blade.php` dan `admin-login.blade.php`

---

## 📚 File yang Masih Perlu Dibuat/Update (untuk implementasi lengkap)

- `resources/views/auth/register.blade.php` - Form registrasi customer
- `resources/views/layouts/app.blade.php` - Layout base yang diextend kedua login form
- Update controller admin untuk dashboard
- Update navbar/header untuk menampilkan status login

---

**✅ Sistem login terpisah sudah siap digunakan!**
