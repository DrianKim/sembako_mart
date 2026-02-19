<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Login

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('hide.login');

Route::post('/allow-login', function () {
    session(['allow_login_access' => true]);
    return response()->json(['success' => true]);
})->middleware('web');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


    // Kategori
    Route::get('/kategori', [AdminController::class, 'kategoriIndex'])->name('kategori');
    Route::get('/kategori/create', [AdminController::class, 'kategoriCreate'])->name('kategori.create');
    Route::post('/kategori/store', [AdminController::class, 'kategoriStore'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [AdminController::class, 'kategoriEdit'])->name('kategori.edit');
    Route::put('/kategori/{id}/update', [AdminController::class, 'kategoriUpdate'])->name('kategori.update');
    Route::delete('/kategori/{id}/delete', [AdminController::class, 'kategoriDelete'])->name('kategori.delete');

    // Produk
    Route::get('/produk', [AdminController::class, 'produkIndex'])->name('produk');
    Route::get('/produk/create', [AdminController::class, 'produkCreate'])->name('produk.create');
    Route::post('/produk/store', [AdminController::class, 'produkStore'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminController::class, 'produkEdit'])->name('produk.edit');
    Route::put('/produk/{id}/update', [AdminController::class, 'produkUpdate'])->name('produk.update');
    Route::delete('/produk/{id}/delete', [AdminController::class, 'produkDelete'])->name('produk.delete');

    // Stok
    Route::get('/stok', [AdminController::class, 'stokIndex'])->name('stok');
    Route::get('/stok/create', [AdminController::class, 'stokCreate'])->name('stok.create');
    Route::post('/stok/store', [AdminController::class, 'stokStore'])->name('stok.store');
    Route::get('/stok/{id}/edit', [AdminController::class, 'stokEdit'])->name('stok.edit');
    Route::put('/stok/{id}/update', [AdminController::class, 'stokUpdate'])->name('stok.update');
});

// Kasir
Route::middleware(['auth', 'role:kasir'])->prefix('/kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('dashboard');
});

// Owner
Route::middleware(['auth', 'role:owner'])->prefix('/owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () {
        return view('owner.dashboard');
    })->name('dashboard');
});
