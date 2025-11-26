<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show form to create review
     */
    public function create(Request $request)
    {
        $id_buku = $request->query('buku');
        $id_pesanan = $request->query('pesanan');

        $buku = Buku::findOrFail($id_buku);
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)
                          ->where('id_user', Auth::id())
                          ->where('status_pengiriman', 'selesai')
                          ->firstOrFail();

        // Check if user already reviewed this book from this order
        $existingReview = Review::where('id_user', Auth::id())
                                ->where('id_buku', $id_buku)
                                ->where('id_pesanan', $id_pesanan)
                                ->first();

        if ($existingReview) {
            return redirect()->route('pesanan.show', $id_pesanan)
                           ->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        // Verify the book was in this order
        $detail = DetailPesanan::where('id_pesanan', $id_pesanan)
                               ->where('id_buku', $id_buku)
                               ->first();

        if (!$detail) {
            return redirect()->route('pesanan.show', $id_pesanan)
                           ->with('error', 'Buku tidak ditemukan dalam pesanan ini.');
        }

        return view('pelanggan.review.create', compact('buku', 'pesanan'));
    }

    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:t_buku,id_buku',
            'id_pesanan' => 'required|exists:t_pesanan,id_pesanan',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        // Verify ownership and order status
        $pesanan = Pesanan::where('id_pesanan', $request->id_pesanan)
                          ->where('id_user', Auth::id())
                          ->where('status_pengiriman', 'selesai')
                          ->firstOrFail();

        // Check if already reviewed
        $existingReview = Review::where('id_user', Auth::id())
                                ->where('id_buku', $request->id_buku)
                                ->where('id_pesanan', $request->id_pesanan)
                                ->first();

        if ($existingReview) {
            return redirect()->route('pesanan.show', $request->id_pesanan)
                           ->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        Review::create([
            'id_user' => Auth::id(),
            'id_buku' => $request->id_buku,
            'id_pesanan' => $request->id_pesanan,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return redirect()->route('pesanan.show', $request->id_pesanan)
                       ->with('success', 'Terima kasih! Ulasan Anda telah berhasil dikirim.');
    }

    /**
     * Get reviews for a book (API/AJAX)
     */
    public function getBookReviews($id_buku)
    {
        $reviews = Review::with('user')
                        ->where('id_buku', $id_buku)
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(5);

        return response()->json($reviews);
    }
}
