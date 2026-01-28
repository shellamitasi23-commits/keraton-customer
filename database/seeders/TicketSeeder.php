<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        TicketCategory::create([
            'name' => 'Tiket Pelajar/Mahasiswa',
            'price' => 10000,
            'description' => 'Untuk pelajar dan mahasiswa dengan kartu identitas',
            'image' => 'tickets/ilustrasi-siswa-sma_169.jpeg'
        ]);

        TicketCategory::create([
            'name' => 'Tiket Umum',
            'price' => 20000,
            'description' => 'Untuk pengunjung umum',
            'image' => 'tickets/kasepuhan-1.jpg'
        ]);

        TicketCategory::create([
            'name' => 'Tiket Warga Negara Asing (WNA)',
            'price' => 20000,
            'description' => 'Wisatawan mancanegara',
            'image' => 'tickets/arsitektur.jpg'
        ]);

        TicketCategory::create([
            'name' => 'Tiket Paket Keluarga',
            'price' => 100000,
            'description' => 'Paket untuk keluarga',
            'image' => 'tickets/bangunan-joglo.jpg'
        ]);

        TicketCategory::create([
            'name' => 'Tiket Paket All In',
            'price' => 30000,
            'description' => 'Paket lengkap dengan fasilitas tambahan',
            'image' => 'tickets/dalem-agung.jpg'
        ]);
    }
}