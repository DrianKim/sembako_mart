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
