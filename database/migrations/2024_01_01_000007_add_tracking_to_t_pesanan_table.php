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
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->string('no_resi')->nullable()->after('alamat_kirim');
            $table->string('kurir')->nullable()->after('no_resi');
            $table->timestamp('waktu_bayar')->nullable()->after('kurir');
            $table->timestamp('waktu_kirim')->nullable()->after('waktu_bayar');
            $table->timestamp('waktu_selesai')->nullable()->after('waktu_kirim');
            $table->text('catatan_admin')->nullable()->after('waktu_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_pesanan', function (Blueprint $table) {
            $table->dropColumn(['no_resi', 'kurir', 'waktu_bayar', 'waktu_kirim', 'waktu_selesai', 'catatan_admin']);
        });
    }
};
