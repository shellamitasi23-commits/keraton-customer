# ✅ SISTEM LOGIN CUSTOMER (EMAIL) & ADMIN (USERNAME) - IMPLEMENTASI LENGKAP

## 🎯 Ringkasan Singkat

Sistem login Keraton Museum sekarang memiliki **2 jalur terpisah**:

- **Customer**: Login dengan `email` + password
- **Admin**: Login dengan `username` + password

---

## 📦 File yang Dibuat/Diupdate

### ✅ Database & Config

| File                                                    | Perubahan                                                 |
| ------------------------------------------------------- | --------------------------------------------------------- |
| `2026_01_17_000000_add_admin_fields_to_users_table.php` | **BARU** - Tambah kolom `username`, update `role` default |
| `config/auth.php`                                       | Tambah guard `admin` & provider `admin`                   |
| `bootstrap/app.php`                                     | Register middleware alias `admin`                         |

### ✅ Models

| File                  | Perubahan                                        |
| --------------------- | ------------------------------------------------ |
| `app/Models/User.php` | Update `$fillable` untuk `username` dan `avatar` |

### ✅ Controllers & Middleware

| File                                      | Perubahan                                                                |
| ----------------------------------------- | ------------------------------------------------------------------------ |
| `app/Http/Controllers/AuthController.php` | **REWRITTEN** - 4 methods: login customer, admin login, logout, register |
| `app/Http/Middleware/IsAdmin.php`         | Update untuk cek guard `admin` & role `admin`                            |

### ✅ Routes

| File             | Perubahan                                                      |
| ---------------- | -------------------------------------------------------------- |
| `routes/web.php` | Routes login customer & admin terpisah, admin routes protected |

### ✅ Views (Blade Templates)

| File                                               | Perubahan                                 |
| -------------------------------------------------- | ----------------------------------------- |
| `resources/views/layouts/app.blade.php`            | **BARU** - Layout base dengan navbar      |
| `resources/views/auth/customer-login.blade.php`    | **UPDATED** - Form login customer (email) |
| `resources/views/auth/admin-login.blade.php`       | **BARU** - Form login admin (username)    |
| `resources/views/auth/customer-register.blade.php` | **BARU** - Form registrasi customer       |

### ✅ Seeders

| File                                      | Perubahan                                    |
| ----------------------------------------- | -------------------------------------------- |
| `database/seeders/AdminAndUserSeeder.php` | **BARU** - Seeder untuk 2 admin & 5 customer |
| `database/seeders/DatabaseSeeder.php`     | Update untuk memanggil AdminAndUserSeeder    |

### 📚 Dokumentasi

| File                            | Tujuan                     |
| ------------------------------- | -------------------------- |
| `LOGIN_SYSTEM_DOCUMENTATION.md` | Dokumentasi lengkap sistem |
| `QUICK_SETUP.md`                | Panduan ini                |

---

## 🚀 Quick Start (5 Langkah)

### 1️⃣ Run Migration

```bash
php artisan migrate
```

### 2️⃣ Run Seeder (untuk test data)

```bash
php artisan db:seed --class=AdminAndUserSeeder
# Atau semua seeder:
php artisan db:seed
```

### 3️⃣ Start Server

```bash
php artisan serve
```

### 4️⃣ Akses URL

- **Customer Login**: `http://localhost:8000/login`
- **Admin Login**: `http://localhost:8000/admin/login`
- **Home Page**: `http://localhost:8000/`

### 5️⃣ Test Login Credentials

**Admin:**

```
Username: admin
Password: admin123
```

**Customer:**

```
Email: budi@gmail.com
Password: password123
```

---

## 🔐 Security Flow

```
┌─────────────────────────────────────────────────────────┐
│              LOGIN FLOW DIAGRAM                         │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  CUSTOMER LOGIN                 ADMIN LOGIN             │
│  ──────────────                 ──────────              │
│  /login                         /admin/login             │
│    ↓                              ↓                      │
│  Validate email                 Validate username        │
│  exists in DB                   exists in DB             │
│    ↓                              ↓                      │
│  Cek role != admin              Cek role == admin       │
│    ↓                              ↓                      │
│  Auth::guard('web')             Auth::guard('admin')     │
│  attempt(email, password)       attempt(username, pwd)   │
│    ↓                              ↓                      │
│  Redirect to                    Redirect to              │
│  customer.home                  admin.dashboard          │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## 📝 Penggunaan di Code

### Cek User Login

```php
// Check customer logged in
if (Auth::guard('web')->check()) {
    $customer = Auth::guard('web')->user();
}

// Check admin logged in
if (Auth::guard('admin')->check()) {
    $admin = Auth::guard('admin')->user();
}
```

### Protect Routes

```php
// Customer routes (email login)
Route::middleware(['auth'])->group(function() {
    // Routes here
});

// Admin routes (username login)
Route::middleware(['admin'])->group(function() {
    // Hanya admin yang bisa akses
});
```

### Logout

```php
// Customer logout
Auth::guard('web')->logout();

// Admin logout
Auth::guard('admin')->logout();
```

---

## 🛡️ Features Keamanan

✅ **Password Hashing** - Otomatis dengan `bcrypt`
✅ **Session Regeneration** - Setelah login berhasil
✅ **Guard Separation** - Terpisah antara customer & admin
✅ **Role Validation** - Cek role di middleware
✅ **Input Validation** - Email, username, password wajib
✅ **Error Handling** - Custom error messages (Bahasa Indonesia)
✅ **CSRF Protection** - `@csrf` di semua form

---

## 📊 Database Structure

### Users Table Fields

```
id              INT (primary)
name            VARCHAR(255)
username        VARCHAR(255) nullable, unique
email           VARCHAR(255) unique
password        VARCHAR(255)
phone           VARCHAR(255) nullable
role            VARCHAR(255) default 'customer'
avatar          VARCHAR(255) nullable
email_verified_at  TIMESTAMP nullable
remember_token  VARCHAR(100) nullable
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Role Values

- `customer` - Login dengan email
- `admin` - Login dengan username

---

## 🧪 Testing

### Test Customer Login Flow

1. Buka `http://localhost:8000/login`
2. Input: `budi@gmail.com` / `password123`
3. Klik "Login"
4. Redirect ke homepage sebagai customer
5. Navbar menampilkan: "Halo, Budi Santoso"

### Test Admin Login Flow

1. Buka `http://localhost:8000/admin/login`
2. Input: `admin` / `admin123`
3. Klik "Login Admin"
4. Redirect ke dashboard admin
5. Navbar menampilkan: "Admin: Admin Keraton"

### Test Registration

1. Buka `http://localhost:8000/register`
2. Isi form dengan data baru
3. Klik "Daftar"
4. Akan redirect ke login page
5. Login dengan email & password yang baru

---

## ⚠️ Troubleshooting

| Problem                   | Solution                                 |
| ------------------------- | ---------------------------------------- |
| Migration error           | `php artisan migrate:fresh --seed`       |
| Middleware not found      | Restart server: `php artisan serve`      |
| View not found            | Pastikan file di `resources/views/auth/` |
| Login gagal               | Cek seeder sudah dijalankan              |
| Guard 'admin' not defined | Check `config/auth.php`                  |

---

## 📚 Helpful Commands

```bash
# Migrate database
php artisan migrate

# Seed database
php artisan db:seed

# Seed specific class
php artisan db:seed --class=AdminAndUserSeeder

# Fresh migrate + seed
php artisan migrate:fresh --seed

# List routes
php artisan route:list

# Cache config
php artisan config:cache

# Clear cache
php artisan cache:clear
```

---

## 🎉 Selesai!

Sistem login **Customer (Email)** & **Admin (Username)** sudah siap digunakan!

**Fitur Tambahan yang Bisa Dikembangkan:**

- [ ] Email verification untuk customer
- [ ] Password reset functionality
- [ ] Two-factor authentication
- [ ] Social login (Google, Facebook)
- [ ] Admin role management
- [ ] User activity logging
- [ ] IP whitelist untuk admin

---

**Created on**: January 17, 2026
**Version**: 1.0
**Status**: ✅ Ready to Use
