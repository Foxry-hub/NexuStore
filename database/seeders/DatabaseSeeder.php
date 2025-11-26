<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@nexustore.com',
            'password' => Hash::make('admin123'),
            'alamat' => 'Jl. Admin No. 1',
            'role' => 'admin',
        ]);

        // Create Sample Customer
        User::create([
            'username' => 'customer1',
            'nama_lengkap' => 'Customer Sample',
            'email' => 'customer@nexustore.com',
            'password' => Hash::make('customer123'),
            'alamat' => 'Jl. Customer No. 1',
            'role' => 'pelanggan',
        ]);

        // Seed Books and Categories
        $this->call([
            BukuSeeder::class,
        ]);
    }
}
