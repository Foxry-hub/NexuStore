<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pesanan;
use App\Models\Review;
use App\Models\Keranjang;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Total pesanan
        $totalPesanan = Pesanan::where('id_user', $user->id_user)->count();
        
        // Pesanan dalam pengiriman
        $pesananDikirim = Pesanan::where('id_user', $user->id_user)
                                  ->where('status_pengiriman', 'dikirim')
                                  ->count();
        
        // Pesanan selesai
        $pesananSelesai = Pesanan::where('id_user', $user->id_user)
                                  ->where('status_pengiriman', 'selesai')
                                  ->count();
        
        // Pesanan menunggu pembayaran
        $pesananMenunggu = Pesanan::where('id_user', $user->id_user)
                                   ->where('status_pembayaran', 'belum_bayar')
                                   ->count();
        
        // Pesanan diproses
        $pesananDiproses = Pesanan::where('id_user', $user->id_user)
                                   ->where('status_pembayaran', 'sudah_bayar')
                                   ->where('status_pengiriman', 'diproses')
                                   ->count();
        
        // Total review
        $totalReview = Review::where('id_user', $user->id_user)->count();
        
        // Item di keranjang
        $itemKeranjang = Keranjang::where('id_user', $user->id_user)->count();
        
        // Total belanja (pesanan yang sudah bayar)
        $totalBelanja = Pesanan::where('id_user', $user->id_user)
                                ->where('status_pembayaran', 'sudah_bayar')
                                ->sum('total_harga');
        
        // Pesanan terbaru (5 terakhir)
        $recentOrders = Pesanan::where('id_user', $user->id_user)
                               ->orderBy('created_at', 'desc')
                               ->take(5)
                               ->get();
        
        return view('pelanggan.dashboard', compact(
            'totalPesanan',
            'pesananDikirim',
            'pesananSelesai',
            'pesananMenunggu',
            'pesananDiproses',
            'totalReview',
            'itemKeranjang',
            'totalBelanja',
            'recentOrders'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $totalPesanan = Pesanan::where('id_user', $user->id_user)->count();
        $totalReview = Review::where('id_user', $user->id_user)->count();
        
        return view('pelanggan.profile', compact('totalPesanan', 'totalReview'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'username' => 'required|string|max:255|unique:t_user,username,' . $user->id_user . ',id_user',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:t_user,email,' . $user->id_user . ',id_user',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $user */
        $user->update([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('pelanggan.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pelanggan.profile')->with('success', 'Password berhasil diubah!');
    }
}
