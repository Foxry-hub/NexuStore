<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananUserController extends Controller
{
    /**
     * Display list of orders
     */
    public function index()
    {
        $user = Auth::user();

        $pesanans = Pesanan::with('detailPesanan')
            ->where('id_user', $user->id_user)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.pesanan.index', compact('pesanans'));
    }

    /**
     * Display order detail
     */
    public function show($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::with('detailPesanan.buku')
            ->where('id_pesanan', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        return view('pelanggan.pesanan.show', compact('pesanan'));
    }

    /**
     * Cancel order (only if belum_bayar)
     */
    public function cancel($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::with('detailPesanan.buku')
            ->where('id_pesanan', $id)
            ->where('id_user', $user->id_user)
            ->where('status_pembayaran', 'belum_bayar')
            ->firstOrFail();

        // Return stock
        foreach ($pesanan->detailPesanan as $detail) {
            $detail->buku->increment('stok', $detail->jumlah);
        }

        // Update status
        $pesanan->update([
            'status_pembayaran' => 'dibatalkan',
            'status_pengiriman' => 'dibatalkan',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Confirm order received
     */
    public function confirmReceived($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('id_user', $user->id_user)
            ->where('status_pengiriman', 'dikirim')
            ->firstOrFail();

        $pesanan->update([
            'status_pengiriman' => 'selesai',
            'waktu_selesai' => now(),
        ]);

        return back()->with('success', 'Pesanan dikonfirmasi telah diterima. Terima kasih telah berbelanja di NEXUSTORE!');
    }
}
