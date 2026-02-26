@extends('kasir.layouts.app')
@section('title', 'Dashboard Kasir')
@section('page-description', 'Ringkasan aktivitas kasir hari ini.')

@section('content')
    <div class="space-y-6">
        <!-- Greeting + Quick Stats -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama ?? 'Kasir' }}</h1>
                <p class="text-gray-600">Hari ini {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('kasir.transaksi') }}"
                    class="flex items-center px-5 py-3 text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
                    <i class="mr-2 fas fa-cash-register"></i> Transaksi Baru
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Omzet Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Omzet Hari Ini</p>
                        <p class="text-3xl font-bold text-green-600">Rp 2.450.000</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-full">
                        <i class="text-3xl text-green-600 fas fa-wallet"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-green-600">+8% dari kemarin</p>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                        <p class="text-3xl font-bold text-blue-600">68</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-full">
                        <i class="text-3xl text-blue-600 fas fa-receipt"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-blue-600">Rata-rata Rp 36.029/transaksi</p>
            </div>

            <!-- Produk Stok Rendah -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Produk Stok < 10</p>
                                <p class="text-3xl font-bold text-red-600">12</p>
                    </div>
                    <div class="p-4 bg-red-100 rounded-full">
                        <i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <p class="mt-2 text-sm text-red-600">Segera cek & restock!</p>
            </div>
        </div>

        <!-- Recent Transaksi -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
                <a href="{{ route('kasir.riwayat_transaksi') }}" class="text-sm font-medium text-green-600 hover:underline">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-4">
                <!-- Dummy Recent 1 -->
                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">TRX-20260226-068</p>
                        <p class="text-sm text-gray-600">Budi • 14:45 WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">Rp 185.000</p>
                    </div>
                </div>

                <!-- Dummy Recent 2 -->
                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">TRX-20260226-067</p>
                        <p class="text-sm text-gray-600">Ani • 15:12 WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">Rp 92.500</p>
                    </div>
                </div>

                <!-- Dummy Recent 3 -->
                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50">
                    <div>
                        <p class="font-medium">TRX-20260226-066</p>
                        <p class="text-sm text-gray-600">Rina • 16:30 WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">Rp 450.000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        {{-- <div class="grid grid-cols-1 gap-6 mt-6 md:grid-cols-2">
            <a href="{{ route('kasir.transaksi') }}"
                class="p-6 transition bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-4 bg-green-100 rounded-full">
                        <i class="text-3xl text-green-600 fas fa-cash-register"></i>
                    </div>
                    <div class="ml-5">
                        <h4 class="text-lg font-semibold text-gray-800">Transaksi Baru</h4>
                        <p class="text-sm text-gray-600">Mulai input penjualan sekarang</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kasir.riwayat_transaksi') }}"
                class="p-6 transition bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md">
                <div class="flex items-center">
                    <div class="p-4 bg-blue-100 rounded-full">
                        <i class="text-3xl text-blue-600 fas fa-history"></i>
                    </div>
                    <div class="ml-5">
                        <h4 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h4>
                        <p class="text-sm text-gray-600">Lihat semua transaksi hari ini</p>
                    </div>
                </div>
            </a>
        </div> --}}
    </div>
@endsection
