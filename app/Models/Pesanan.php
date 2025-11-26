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
        'status_pembayaran',
        'status_pengiriman',
        'alamat_kirim',
        'no_resi',
        'kurir',
        'waktu_bayar',
        'waktu_kirim',
        'waktu_selesai',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'date',
        'total_harga' => 'decimal:2',
        'waktu_bayar' => 'datetime',
        'waktu_kirim' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    /**
     * Get status pembayaran label
     */
    public function getStatusPembayaranLabelAttribute()
    {
        return match($this->status_pembayaran) {
            'belum_bayar' => 'Belum Bayar',
            'sudah_bayar' => 'Sudah Bayar',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status_pembayaran,
        };
    }

    /**
     * Get status pengiriman label
     */
    public function getStatusPengirimanLabelAttribute()
    {
        return match($this->status_pengiriman) {
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => $this->status_pengiriman,
        };
    }

    /**
     * Get formatted order code
     */
    public function getKodePesananAttribute()
    {
        return 'NXS-' . str_pad($this->id_pesanan, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled()
    {
        return $this->status_pembayaran === 'belum_bayar' && 
               $this->status_pengiriman === 'diproses';
    }

    /**
     * Check if order is being shipped
     */
    public function isBeingShipped()
    {
        return $this->status_pengiriman === 'dikirim';
    }

    /**
     * Get tracking URL based on courier
     */
    public function getTrackingUrlAttribute()
    {
        if (!$this->no_resi || !$this->kurir) {
            return null;
        }

        $urls = [
            'jne' => 'https://www.jne.co.id/id/tracking/trace',
            'jnt' => 'https://www.jet.co.id/track',
            'sicepat' => 'https://www.sicepat.com/checkAwb',
            'anteraja' => 'https://anteraja.id/tracking',
            'pos' => 'https://www.posindonesia.co.id/id/tracking',
        ];

        return $urls[strtolower($this->kurir)] ?? null;
    }
}
