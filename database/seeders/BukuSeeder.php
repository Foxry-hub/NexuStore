<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        Kategori::create([
            'nama_kategori' => 'Fiksi',
            'deskripsi' => 'Buku fiksi dan novel',
        ]);

        Kategori::create([
            'nama_kategori' => 'Non-Fiksi',
            'deskripsi' => 'Buku non-fiksi dan edukatif',
        ]);

        Kategori::create([
            'nama_kategori' => 'Bisnis & Ekonomi',
            'deskripsi' => 'Buku tentang bisnis dan ekonomi',
        ]);

        Kategori::create([
            'nama_kategori' => 'Teknologi',
            'deskripsi' => 'Buku tentang teknologi dan programming',
        ]);

        Kategori::create([
            'nama_kategori' => 'Anak & Remaja',
            'deskripsi' => 'Buku untuk anak-anak dan remaja',
        ]);

    }
}
