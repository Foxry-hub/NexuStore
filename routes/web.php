<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBukuController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminPelangganController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ShopController;

// Public Routes
Route::get('/', function () {
    // Redirect to dashboard if authenticated
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
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
        if (auth()->user()->isAdmin()) {
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
    Route::delete('/pesanan/{id}', [AdminPesananController::class, 'destroy'])->name('pesanan.destroy');
});

// Pelanggan Routes
Route::middleware(['auth', App\Http\Middleware\PelangganMiddleware::class])->prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/profile', [PelangganController::class, 'profile'])->name('pelanggan.profile');
});
