<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'address',
        'postal_code',
        'whatsapp',
        'subtotal',
        'shipping_price',
        'total_price',
        'status',
        'payment_method',
        'payment_proof',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}