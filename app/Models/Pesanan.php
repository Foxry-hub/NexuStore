<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 't_pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'tanggal_pesanan',
        'total_harga',
        'status_pesanan',
        'alamat_pengiriman',
        'metode_pembayaran',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
