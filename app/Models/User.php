<?php

namespace App\Models;

// Import bawaan Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (Mass Assignable)
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
    ]; 

    /**
     * Kolom yang disembunyikan saat data user diambil (Security)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- RELASI KE TABEL LAIN ---

    // 1 User bisa memiliki banyak Transaksi Tiket
    public function ticket_transactions()
    {
        return $this->hasMany(TicketTransaction::class);
    }

    // 1 User bisa memiliki banyak Order Merchandise
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // 1 User bisa memiliki banyak barang di Keranjang
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}