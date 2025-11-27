<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       // Buat 1 User Test
    \App\Models\User::factory()->create([
        'name' => 'Lorena Schuett',
        'email' => 'lorena@gmail.com',
        'phone' => '087668912367',
        'password' => bcrypt('password'), // passwordnya 'password'
        'role' => 'user'
    ]);

    $this->call([
        TicketSeeder::class,
        ProductSeeder::class,
    ]);
}
}