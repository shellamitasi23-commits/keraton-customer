<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jalankan seeder untuk admin dan user
        $this->call([
            AdminSeeder::class,
            ProductSeeder::class,
            TicketSeeder::class,
        ]);
    }
}