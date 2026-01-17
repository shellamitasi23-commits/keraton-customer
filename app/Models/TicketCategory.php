<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function transactions()
    {
        return $this->hasMany(TicketTransaction::class, 'ticket_category_id');
    }
}