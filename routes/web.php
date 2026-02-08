<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
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
