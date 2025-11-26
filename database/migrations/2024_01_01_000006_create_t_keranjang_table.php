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
        Schema::create('t_keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->foreignId('id_user')->constrained('t_user', 'id_user')->onDelete('cascade');
            $table->foreignId('id_buku')->constrained('t_buku', 'id_buku')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->timestamps();
            
            // Unique constraint: satu user hanya bisa punya satu entry per buku
            $table->unique(['id_user', 'id_buku']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keranjang');
    }
};
