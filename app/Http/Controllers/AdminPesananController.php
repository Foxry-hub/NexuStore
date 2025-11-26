<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'detailPesanan']);

        // Filter by status pembayaran
        if ($request->has('status_pembayaran') && $request->status_pembayaran != '') {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Filter by status pengiriman
        if ($request->has('status_pengiriman') && $request->status_pengiriman != '') {
            $query->where('status_pengiriman', $request->status_pengiriman);
        }

        // Search by customer name or order number
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id_pesanan', 'like', '%' . $search . '%')
                  ->orWhere('no_resi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('nama_lengkap', 'like', '%' . $search . '%');
                });
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Pesanan::with(['user', 'detailPesanan.buku'])->findOrFail($id);
        return view('admin.pesanan.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Pesanan::findOrFail($id);

        $request->validate([
            'status_pembayaran' => 'nullable|in:belum_bayar,sudah_bayar,dibatalkan',
            'status_pengiriman' => 'nullable|in:diproses,dikirim,selesai,dibatalkan',
            'no_resi' => 'nullable|string|max:100',
            'kurir' => 'nullable|string|max:50',
            'catatan_admin' => 'nullable|string',
        ]);

        $updateData = [];

        // Update status pembayaran
        if ($request->filled('status_pembayaran')) {
            $updateData['status_pembayaran'] = $request->status_pembayaran;
            if ($request->status_pembayaran === 'sudah_bayar' && !$order->waktu_bayar) {
                $updateData['waktu_bayar'] = now();
            }
        }

        // Update status pengiriman
        if ($request->filled('status_pengiriman')) {
            $updateData['status_pengiriman'] = $request->status_pengiriman;
            
            // Set waktu kirim jika status dikirim
            if ($request->status_pengiriman === 'dikirim' && !$order->waktu_kirim) {
                $updateData['waktu_kirim'] = now();
            }
            
            // Set waktu selesai jika status selesai
            if ($request->status_pengiriman === 'selesai' && !$order->waktu_selesai) {
                $updateData['waktu_selesai'] = now();
            }
        }

        // Update tracking info
        if ($request->filled('no_resi')) {
            $updateData['no_resi'] = $request->no_resi;
        }
        if ($request->filled('kurir')) {
            $updateData['kurir'] = $request->kurir;
        }
        if ($request->filled('catatan_admin')) {
            $updateData['catatan_admin'] = $request->catatan_admin;
        }

        $order->update($updateData);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    /**
     * Ship order - set resi and mark as shipped
     */
    public function ship(Request $request, $id)
    {
        $order = Pesanan::findOrFail($id);

        $request->validate([
            'kurir' => 'required|string|max:50',
            'no_resi' => 'required|string|max:100',
        ]);

        // Only allow shipping if already paid
        if ($order->status_pembayaran !== 'sudah_bayar') {
            return redirect()->back()->with('error', 'Pesanan belum dibayar, tidak bisa dikirim!');
        }

        $order->update([
            'kurir' => $request->kurir,
            'no_resi' => $request->no_resi,
            'status_pengiriman' => 'dikirim',
            'waktu_kirim' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikirim! Nomor resi: ' . $request->no_resi);
    }

    public function destroy($id)
    {
        $order = Pesanan::findOrFail($id);
        
        // Only allow deletion of cancelled orders
        if ($order->status_pembayaran !== 'dibatalkan' && $order->status_pengiriman !== 'dibatalkan') {
            return redirect()->route('admin.pesanan.index')->with('error', 'Hanya pesanan yang dibatalkan yang dapat dihapus!');
        }

        $order->detailPesanan()->delete();
        $order->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
