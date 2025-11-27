<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total counts
        $totalUsers = User::where('role', 'pelanggan')->count();
        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();
        $totalPesanan = Pesanan::count();
        
        // Revenue calculations
        $totalPendapatan = Pesanan::where('status_pembayaran', 'sudah_bayar')->sum('total_harga');
        
        // Orders by status
        $pesananBaru = Pesanan::where('status_pembayaran', 'belum_bayar')
                              ->where('status_pengiriman', 'diproses')
                              ->count();
        $pesananDiproses = Pesanan::where('status_pembayaran', 'sudah_bayar')
                                   ->where('status_pengiriman', 'diproses')
                                   ->count();
        $pesananDikirim = Pesanan::where('status_pengiriman', 'dikirim')->count();
        $pesananSelesai = Pesanan::where('status_pengiriman', 'selesai')->count();
        
        // Recent orders (5 latest)
        $recentOrders = Pesanan::with('user')
                               ->orderBy('created_at', 'desc')
                               ->take(5)
                               ->get();
        
        // Recent users (5 latest customers)
        $recentUsers = User::where('role', 'pelanggan')
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        
        // Low stock books (stock <= 5)
        $lowStockBooks = Buku::where('stok', '<=', 5)
                             ->orderBy('stok', 'asc')
                             ->take(5)
                             ->get();
        
        // Monthly revenue (current month)
        $pendapatanBulanIni = Pesanan::where('status_pembayaran', 'sudah_bayar')
                                      ->whereMonth('created_at', Carbon::now()->month)
                                      ->whereYear('created_at', Carbon::now()->year)
                                      ->sum('total_harga');
        
        // Today's orders
        $pesananHariIni = Pesanan::whereDate('created_at', Carbon::today())->count();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBuku',
            'totalKategori',
            'totalPesanan',
            'totalPendapatan',
            'pesananBaru',
            'pesananDiproses',
            'pesananDikirim',
            'pesananSelesai',
            'recentOrders',
            'recentUsers',
            'lowStockBooks',
            'pendapatanBulanIni',
            'pesananHariIni'
        ));
    }
}
