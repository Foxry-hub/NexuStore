<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pesanan;
use App\Models\Review;

class PelangganController extends Controller
{
    public function dashboard()
    {
        return view('pelanggan.dashboard');
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
            'alamat' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $user */
        $user->update([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
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
