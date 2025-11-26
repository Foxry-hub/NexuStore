<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 't_buku';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'id_kategori',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'jumlah_halaman',
        'deskripsi',
        'harga',
        'stok',
        'gambar_cover',
    ];

    /**
     * Get the category that owns the book.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Get the reviews for the book.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_buku', 'id_buku');
    }

    /**
     * Get approved reviews only.
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'id_buku', 'id_buku')->where('is_approved', true);
    }

    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count.
     */
    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get rating rounded.
     */
    public function getRatingRoundedAttribute()
    {
        return round($this->average_rating);
    }
}
