<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $cartItems = Keranjang::with('buku.kategori')
            ->where('id_user', $user->id_user)
            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->buku->harga * $item->jumlah;
        });
        
        return view('pelanggan.keranjang.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:t_buku,id_buku',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $jumlah = $request->jumlah ?? 1;

        // Check book stock
        $buku = Buku::findOrFail($request->id_buku);
        if ($buku->stok < $jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        // Check if item already in cart
        $cartItem = Keranjang::where('id_user', $user->id_user)
            ->where('id_buku', $request->id_buku)
            ->first();

        if ($cartItem) {
            // Update quantity
            $newQty = $cartItem->jumlah + $jumlah;
            if ($newQty > $buku->stok) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $cartItem->update(['jumlah' => $newQty]);
        } else {
            // Create new cart item
            Keranjang::create([
                'id_user' => $user->id_user,
                'id_buku' => $request->id_buku,
                'jumlah' => $jumlah,
            ]);
        }

        return back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $cartItem = Keranjang::where('id_keranjang', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        // Check stock
        if ($request->jumlah > $cartItem->buku->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $cartItem->update(['jumlah' => $request->jumlah]);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $cartItem = Keranjang::where('id_keranjang', $id)
            ->where('id_user', $user->id_user)
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Get cart count for navbar
     */
    public static function getCartCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Keranjang::where('id_user', $user->id_user)->sum('jumlah');
    }
}
