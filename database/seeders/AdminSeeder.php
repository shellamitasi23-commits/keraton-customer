<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('username', 'admin')->first();

        if (!$adminExists) {
            User::create([
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@keraton.com',
                'password' => Hash::make('keraton2026'), // Ganti dengan password yang Anda inginkan
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}