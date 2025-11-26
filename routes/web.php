<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBukuController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananUserController;
use App\Http\Controllers\ReviewController;

// Public Routes
Route::get('/', function () {
    // Redirect to dashboard if authenticated
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pelanggan.dashboard');
    }
    return view('landing');
})->name('home');

// Shop Routes (accessible to all)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pelanggan.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Buku Management
    Route::resource('buku', AdminBukuController::class);
    
    // Kategori Management
    Route::resource('kategori', AdminKategoriController::class);
    
    // Pelanggan Management
    Route::get('/pelanggan', [AdminPelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{id}', [AdminPelangganController::class, 'show'])->name('pelanggan.show');
    Route::delete('/pelanggan/{id}', [AdminPelangganController::class, 'destroy'])->name('pelanggan.destroy');
    
    // Pesanan Management
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::post('/pesanan/{id}/ship', [AdminPesananController::class, 'ship'])->name('pesanan.ship');
    Route::delete('/pesanan/{id}', [AdminPesananController::class, 'destroy'])->name('pesanan.destroy');
});

// Pelanggan Routes
Route::middleware(['auth', App\Http\Middleware\PelangganMiddleware::class])->prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/profile', [PelangganController::class, 'profile'])->name('pelanggan.profile');
    Route::put('/profile', [PelangganController::class, 'updateProfile'])->name('pelanggan.profile.update');
    Route::put('/password', [PelangganController::class, 'updatePassword'])->name('pelanggan.password.update');
    
    // Keranjang Routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/add', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    
    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/pembayaran/{id}', [CheckoutController::class, 'showPayment'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}', [CheckoutController::class, 'processPayment'])->name('pembayaran.process');
    
    // Pesanan Routes
    Route::get('/pesanan', [PesananUserController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananUserController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/cancel', [PesananUserController::class, 'cancel'])->name('pesanan.cancel');
    Route::post('/pesanan/{id}/confirm', [PesananUserController::class, 'confirmReceived'])->name('pesanan.confirm');
    
    // Review Routes
    Route::get('/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
});
