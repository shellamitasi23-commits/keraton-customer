<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Blangkon',
            'price' => 10000,
            'stock' => 50,
            'category' => 'Fashion',
            'description' => 'Penutup kepala tradisional khas Jawa',
            'image' => 'blangkon.jpg' 
        ]);

        Product::create([
            'name' => 'Topeng Figura',
            'price' => 250000,
            'stock' => 10,
            'category' => 'Souvenir',
            'description' => 'Topeng gaya Cirebon yang dibuat dari kayu',
            'image' => 'Topeng-Figura.jpg'
        ]);

        Product::create([
            'name' => 'Baju Kaos',
            'price' => 60000,
            'stock' => 100,
            'category' => 'Fashion',
            'description' => 'Baju Merchandise Keraton Kasepuhan',
            'image' => 'Kaos.jpg'
        ]);
    }
}