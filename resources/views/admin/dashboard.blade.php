@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-description', 'Halaman utama untuk mengelola sistem toko sembako.')

@section('content')
    <div class="space-y-6">

        <!-- Greeting + Quick Stats -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, Admin</h1>
                <p class="text-gray-600">Ini ringkasan aktivitas toko hari ini (20 Februari 2026)</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.produk.create') }}"
                    class="flex items-center px-4 py-2.5 text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">
                    <i class="mr-2 fas fa-plus"></i> Tambah Produk
                </a>
                <a href="{{ route('admin.stok.create') }}"
                    class="flex items-center px-4 py-2.5 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                    <i class="mr-2 fas fa-boxes"></i> Tambah Stok
                </a>
            </div>
        </div>

        <!-- Stat Cards (4 kolom di desktop) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Omzet Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Omzet Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600">Rp 4.850.000</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="text-2xl text-green-600 fas fa-wallet"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">+12% dari kemarin</p>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold text-blue-600">128</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="text-2xl text-blue-600 fas fa-receipt"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-blue-600">Rata-rata Rp 37.890/transaksi</p>
            </div>

            <!-- Produk Hampir Habis -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Produk Stok < 10</p>
                                <p class="text-2xl font-bold text-red-600">17</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="text-2xl text-red-600 fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-red-600">Segera restock!</p>
            </div>

            <!-- Kasir Aktif -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Kasir Aktif</p>
                        <p class="text-2xl font-bold text-purple-600">4</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="text-2xl text-purple-600 fas fa-users"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-purple-600">Online sekarang</p>
            </div>
        </div>

        <!-- Chart & Recent Activity (2 kolom) -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Chart Omzet 7 Hari Terakhir -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Omzet 7 Hari Terakhir</h3>
                <div class="flex items-center justify-center h-64 rounded-lg bg-gray-50">
                    <p class="text-gray-500">[Placeholder Chart Omzet - Pakai Chart.js nanti]</p>
                </div>
            </div>

            <!-- Recent Transaksi -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
                <div class="space-y-4">
                    <!-- Dummy Recent 1 -->
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                        <div>
                            <p class="font-medium">TRX-20260220-128</p>
                            <p class="text-sm text-gray-600">Andi Susanto • Budi</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">Rp 185.000</p>
                            <p class="text-xs text-gray-500">14:45 WIB</p>
                        </div>
                    </div>

                    <!-- Dummy Recent 2 -->
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                        <div>
                            <p class="font-medium">TRX-20260220-127</p>
                            <p class="text-sm text-gray-600">Siti Rahayu • Ani</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">Rp 92.500</p>
                            <p class="text-xs text-gray-500">15:30 WIB</p>
                        </div>
                    </div>

                    <!-- Dummy Recent 3 -->
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                        <div>
                            <p class="font-medium">TRX-20260220-126</p>
                            <p class="text-sm text-gray-600">Andi Susanto • Rina</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-green-600">Rp 450.000</p>
                            <p class="text-xs text-gray-500">16:10 WIB</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.riwayat_transaksi') }}"
                    class="block mt-4 text-center text-green-600 hover:underline">
                    Lihat Semua Transaksi →
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-3">
            <a href="{{ route('admin.produk') }}"
                class="p-6 transition bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="text-2xl text-green-600 fas fa-box"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-800">Kelola Produk</h4>
                        <p class="text-sm text-gray-600">Tambah, edit, hapus produk</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.stok') }}"
                class="p-6 transition bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="text-2xl text-blue-600 fas fa-boxes"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-800">Kelola Stok</h4>
                        <p class="text-sm text-gray-600">Cek stok rendah & tambah stok</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.kasir') }}"
                class="p-6 transition bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="text-2xl text-purple-600 fas fa-user-tie"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-800">Kelola Kasir</h4>
                        <p class="text-sm text-gray-600">Tambah/ubah status kasir</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
