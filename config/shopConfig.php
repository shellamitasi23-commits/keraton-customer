<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shop Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk toko merchandise Keraton Cirebon
    |
    */

    // Pengaturan Ongkir
    'shipping' => [
        'default_price' => 15000, // Rp 15.000
        'free_shipping_minimum' => 500000, // Gratis ongkir untuk pembelian >= Rp 500.000
    ],

    // Pengaturan Stok
    'stock' => [
        'low_stock_threshold' => 10, // Warning jika stok < 10
        'critical_stock_threshold' => 5, // Critical jika stok < 5
    ],

    // Pengaturan Cart
    'cart' => [
        'max_quantity_per_item' => 100, // Max quantity per item di cart
        'max_items_in_cart' => 20, // Max jumlah produk berbeda di cart
    ],

    // Pengaturan Image
    'image' => [
        'max_size' => 2048, // KB (2MB)
        'allowed_types' => ['jpeg', 'png', 'jpg', 'gif', 'webp'],
        'storage_path' => 'products',
    ],

    // Pengaturan Order
    'order' => [
        'order_number_prefix' => 'ORD',
        'order_number_length' => 10,
        'auto_cancel_hours' => 24, // Auto cancel order jika tidak dibayar dalam 24 jam
    ],

    // Pagination
    'pagination' => [
        'products_per_page' => 12,
        'orders_per_page' => 20,
        'admin_sales_limit' => 50, // Limit sales di admin panel
    ],
];