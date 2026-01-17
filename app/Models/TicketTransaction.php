<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_category_id',
        'transaction_code',
        'visit_date',
        'total_ticket',
        'total_price',
        'payment_proof',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke TicketCategory (ini yang kurang!)
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    // Atau bisa juga pakai nama lain sesuai kebiasaan Laravel
    public function ticket_category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }
}