<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminPelangganController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'pelanggan')
            ->withCount(['pesanan'])
            ->latest()
            ->paginate(15);
        return view('admin.pelanggan.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'pelanggan')
            ->with(['pesanan.detailPesanan.buku'])
            ->findOrFail($id);
        return view('admin.pelanggan.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'pelanggan')->findOrFail($id);
        
        // Check if customer has orders
        if ($customer->pesanan()->count() > 0) {
            return redirect()->route('admin.pelanggan.index')->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat pesanan!');
        }

        $customer->delete();
        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
