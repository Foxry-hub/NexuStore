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
        Schema::create('t_pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_user')->constrained('t_user', 'id_user')->onDelete('cascade');
            $table->date('tanggal_pesanan');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar', 'dibatalkan'])->default('belum_bayar');
            $table->enum('status_pengiriman', ['diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('diproses');
            $table->text('alamat_kirim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pesanan');
    }
};
