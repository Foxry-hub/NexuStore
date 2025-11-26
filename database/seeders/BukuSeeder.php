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
        $fiksi = Kategori::create([
            'nama_kategori' => 'Fiksi',
            'deskripsi' => 'Buku fiksi dan novel',
        ]);

        $nonFiksi = Kategori::create([
            'nama_kategori' => 'Non-Fiksi',
            'deskripsi' => 'Buku non-fiksi dan edukatif',
        ]);

        $bisnis = Kategori::create([
            'nama_kategori' => 'Bisnis & Ekonomi',
            'deskripsi' => 'Buku tentang bisnis dan ekonomi',
        ]);

        $teknologi = Kategori::create([
            'nama_kategori' => 'Teknologi',
            'deskripsi' => 'Buku tentang teknologi dan programming',
        ]);

        $anak = Kategori::create([
            'nama_kategori' => 'Anak & Remaja',
            'deskripsi' => 'Buku untuk anak-anak dan remaja',
        ]);

        // Create Books
        $books = [
            [
                'id_kategori' => $fiksi->id_kategori,
                'judul' => '365 Days To Tell My Kids',
                'penulis' => 'Sarah Johnson',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2023,
                'isbn' => '978-602-03-1234-5',
                'jumlah_halaman' => 320,
                'deskripsi' => 'Sebuah kisah indah tentang perjalanan seorang ibu',
                'harga' => 85000,
                'stok' => 15,
            ],
            [
                'id_kategori' => $fiksi->id_kategori,
                'judul' => 'A Raptorcs Quo Runhaus Libreria',
                'penulis' => 'Marcus Williams',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-03-2345-6',
                'jumlah_halaman' => 450,
                'deskripsi' => 'Petualangan menegangkan di dunia fantasi',
                'harga' => 120000,
                'stok' => 10,
            ],
            [
                'id_kategori' => $nonFiksi->id_kategori,
                'judul' => 'A Spot of Folly',
                'penulis' => 'Ruth Rendell',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2021,
                'isbn' => '978-602-03-3456-7',
                'jumlah_halaman' => 280,
                'deskripsi' => 'Kumpulan cerita pendek yang menawan',
                'harga' => 95000,
                'stok' => 20,
            ],
            [
                'id_kategori' => $anak->id_kategori,
                'judul' => 'A Wasted Hour',
                'penulis' => 'Jeffrey Archer',
                'penerbit' => 'Mizan',
                'tahun_terbit' => 2023,
                'isbn' => '978-602-03-4567-8',
                'jumlah_halaman' => 180,
                'deskripsi' => 'Cerita inspiratif untuk remaja',
                'harga' => 75000,
                'stok' => 25,
            ],
            [
                'id_kategori' => $nonFiksi->id_kategori,
                'judul' => 'Battle on The Home Front',
                'penulis' => 'David Johnson',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2020,
                'isbn' => '978-602-03-5678-9',
                'jumlah_halaman' => 520,
                'deskripsi' => 'Kisah nyata dari medan perang',
                'harga' => 150000,
                'stok' => 8,
            ],
            [
                'id_kategori' => $fiksi->id_kategori,
                'judul' => 'Blood Cauldron',
                'penulis' => 'Emma Watson',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2023,
                'isbn' => '978-602-03-6789-0',
                'jumlah_halaman' => 380,
                'deskripsi' => 'Thriller yang menegangkan',
                'harga' => 110000,
                'stok' => 12,
            ],
            [
                'id_kategori' => $bisnis->id_kategori,
                'judul' => "Devil's Mile",
                'penulis' => 'Tony Robbins',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-03-7890-1',
                'jumlah_halaman' => 420,
                'deskripsi' => 'Strategi bisnis modern',
                'harga' => 180000,
                'stok' => 7,
            ],
            [
                'id_kategori' => $anak->id_kategori,
                'judul' => 'Danielle Steel\'s Safe Harbour',
                'penulis' => 'Danielle Steel',
                'penerbit' => 'Mizan',
                'tahun_terbit' => 2021,
                'isbn' => '978-602-03-8901-2',
                'jumlah_halaman' => 290,
                'deskripsi' => 'Cerita hangat tentang keluarga',
                'harga' => 125000,
                'stok' => 18,
            ],
            [
                'id_kategori' => $nonFiksi->id_kategori,
                'judul' => 'Fire And Blood Is a Dry Text',
                'penulis' => 'George Martin',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2023,
                'isbn' => '978-602-03-9012-3',
                'jumlah_halaman' => 610,
                'deskripsi' => 'Sejarah dan analisis mendalam',
                'harga' => 95000,
                'stok' => 14,
            ],
            [
                'id_kategori' => $anak->id_kategori,
                'judul' => 'Jungle Stories',
                'penulis' => 'Rudyard Kipling',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-03-0123-4',
                'jumlah_halaman' => 240,
                'deskripsi' => 'Petualangan seru di hutan',
                'harga' => 85000,
                'stok' => 22,
            ],
            [
                'id_kategori' => $fiksi->id_kategori,
                'judul' => "Julia's Story Belleville family",
                'penulis' => 'Julia Roberts',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2023,
                'isbn' => '978-602-03-1235-5',
                'jumlah_halaman' => 550,
                'deskripsi' => 'Drama keluarga yang mengharukan',
                'harga' => 200000,
                'stok' => 5,
            ],
            [
                'id_kategori' => $teknologi->id_kategori,
                'judul' => 'Magic by Danielle Steel',
                'penulis' => 'Steve Jobs',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2021,
                'isbn' => '978-602-03-2346-6',
                'jumlah_halaman' => 480,
                'deskripsi' => 'Inovasi dan teknologi masa depan',
                'harga' => 165000,
                'stok' => 9,
            ],
        ];

        foreach ($books as $book) {
            Buku::create($book);
        }
    }
}
