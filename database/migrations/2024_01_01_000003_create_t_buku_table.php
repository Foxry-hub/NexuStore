<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->foreignId('id_kategori')->constrained('t_kategori', 'id_kategori')->onDelete('cascade');
            $table->string('judul', 200);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->string('isbn', 20)->nullable()->unique();
            $table->integer('jumlah_halaman');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('gambar_cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_buku');
    }
};
