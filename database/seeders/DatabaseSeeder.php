<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   // database/seeders/DatabaseSeeder.php

public function run(): void
{
    // Gunakan updateOrCreate: Jika email sudah ada, maka di-update. Jika belum, maka dibuat baru.
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@keraton.com'], // Kunci pencarian
        [
            'name' => 'Admin Keraton',
            'username' => 'admin',
            'password' => bcrypt('keraton2026'),
            'phone' => '08123456789',
            'role' => 'admin', 
        ]
    );

    \App\Models\User::updateOrCreate(
        ['email' => 'lorena@gmail.com'],
        [
            'name' => 'Lorena Schuett',
            'username' => 'lorena',
            'phone' => '087668912367',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]
    );

    $this->call([
        TicketSeeder::class,
        ProductSeeder::class,
    ]);
}
}