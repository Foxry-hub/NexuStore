<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $user = Auth::user();
        
        $cartItems = Keranjang::with('buku')
            ->where('id_user', $user->id_user)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->buku->harga * $item->jumlah;
        });

        return view('pelanggan.checkout.index', compact('cartItems', 'total', 'user'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'alamat_kirim' => 'required|string|min:10',
        ]);

        $user = Auth::user();

        $cartItems = Keranjang::with('buku')
            ->where('id_user', $user->id_user)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if ($item->jumlah > $item->buku->stok) {
                return back()->with('error', "Stok buku '{$item->buku->judul}' tidak mencukupi.");
            }
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $totalHarga = $cartItems->sum(function ($item) {
                return $item->buku->harga * $item->jumlah;
            });

            // Create order
            $pesanan = Pesanan::create([
                'id_user' => $user->id_user,
                'tanggal_pesanan' => now(),
                'total_harga' => $totalHarga,
                'status_pembayaran' => 'belum_bayar',
                'status_pengiriman' => 'diproses',
                'alamat_kirim' => $request->alamat_kirim,
            ]);

            // Create order details and reduce stock
            foreach ($cartItems as $item) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_buku' => $item->id_buku,
                    'jumlah' => $item->jumlah,
                    'total' => $item->buku->harga * $item->jumlah,
                ]);

                // Reduce stock
                $item->buku->decrement('stok', $item->jumlah);
            }

            // Clear cart
            Keranjang::where('id_user', $user->id_user)->delete();

            DB::commit();

            return redirect()->route('pembayaran.show', $pesanan->id_pesanan)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    public function showPayment($id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::with('detailPesanan.buku')
            ->where('id_pesanan', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        if ($pesanan->status_pembayaran === 'sudah_bayar') {
            return redirect()->route('pesanan.show', $pesanan->id_pesanan)
                ->with('info', 'Pesanan sudah dibayar.');
        }

        return view('pelanggan.checkout.payment', compact('pesanan'));
    }

    /**
     * Process payment (simulasi)
     */
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,cod',
        ]);

        $user = Auth::user();

        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('id_user', $user->id_user)
            ->where('status_pembayaran', 'belum_bayar')
            ->firstOrFail();

        // Simulasi pembayaran berhasil
        $pesanan->update([
            'status_pembayaran' => 'sudah_bayar',
            'waktu_bayar' => now(),
        ]);

        return redirect()->route('pesanan.show', $pesanan->id_pesanan)
            ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }
}
