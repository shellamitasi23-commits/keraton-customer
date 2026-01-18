<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include products with low stock.
     */
    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<', $threshold);
    }

    /**
     * Scope a query to only include available products.
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get the product's image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Get the stock status.
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock > 10) {
            return 'available';
        } elseif ($this->stock > 0) {
            return 'low';
        }
        return 'out';
    }

    /**
     * Get the stock status badge class.
     */
    public function getStockBadgeClassAttribute()
    {
        return [
            'available' => 'badge-success',
            'low' => 'badge-warning',
            'out' => 'badge-danger',
        ][$this->stock_status] ?? 'badge-secondary';
    }

    /**
     * Get the stock status text.
     */
    public function getStockStatusTextAttribute()
    {
        return [
            'available' => 'Tersedia',
            'low' => 'Stok Sedikit',
            'out' => 'Habis',
        ][$this->stock_status] ?? 'Unknown';
    }
}