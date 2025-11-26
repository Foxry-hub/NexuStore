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
        Schema::create('t_review', function (Blueprint $table) {
            $table->id('id_review');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_buku');
            $table->unsignedBigInteger('id_pesanan');
            $table->tinyInteger('rating')->comment('1-5 stars');
            $table->text('ulasan')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('t_user')->onDelete('cascade');
            $table->foreign('id_buku')->references('id_buku')->on('t_buku')->onDelete('cascade');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('t_pesanan')->onDelete('cascade');
            
            // User hanya bisa review 1x per buku per pesanan
            $table->unique(['id_user', 'id_buku', 'id_pesanan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_review');
    }
};
