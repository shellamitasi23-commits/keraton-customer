<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTransaction extends Model
{
    protected $guarded = ['id']; // Semua boleh diisi kecuali ID

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ticket_category()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}