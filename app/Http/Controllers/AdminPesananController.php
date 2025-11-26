<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'detailPesanan']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pesanan', $request->status);
        }

        // Search by customer name or order number
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
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
            'status_pesanan' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $order = Pesanan::findOrFail($id);
        
        // Only allow deletion of cancelled orders
        if ($order->status_pesanan != 'dibatalkan') {
            return redirect()->route('admin.pesanan.index')->with('error', 'Hanya pesanan yang dibatalkan yang dapat dihapus!');
        }

        $order->detailPesanan()->delete();
        $order->delete();

        return redirect()->route('admin.pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
