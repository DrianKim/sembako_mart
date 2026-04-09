@extends('kasir.layouts.app')
@section('title', 'Dashboard Kasir')
@section('page-description', 'Ringkasan aktivitas kasir hari ini.')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama }}!</h1>
                <p class="text-gray-500 text-sm mt-1">
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <a href="{{ route('kasir.transaksi') }}"
                class="inline-flex items-center px-5 py-3 text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">
                <i class="mr-2 fas fa-cash-register"></i> Transaksi Baru
            </a>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Omzet Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Omzet Saya Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">
                            Rp {{ number_format($omzetHariIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-wallet text-2xl text-green-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm {{ $persenOmzet >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $persenOmzet >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($persenOmzet) }}% dari kemarin
                </p>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Transaksi Saya Hari Ini</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $transaksiHariIni }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-receipt text-2xl text-blue-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm text-blue-600">
                    Rata-rata Rp {{ number_format($rataRata, 0, ',', '.') }}/transaksi
                </p>
            </div>

            <!-- Produk Stok Rendah -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk Stok &lt; 10</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $produkStokRendah }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm text-red-500">
                    {{ $produkStokRendah > 0 ? 'Segera laporkan ke admin!' : 'Stok aman 👍' }}
                </p>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">🧾 Transaksi Terbaru Saya</h3>
                <a href="{{ route('kasir.riwayat_transaksi') }}"
                    class="text-sm font-medium text-green-600 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="space-y-3">
                @forelse($transaksiTerbaru as $trx)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $trx->nomor_unik }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $trx->nama_pelanggan }} •
                                {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('H:i') }} WIB
                            </p>
                        </div>
                        <p class="font-bold text-green-600">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada transaksi hari ini.</p>
                        <a href="{{ route('kasir.transaksi') }}"
                            class="mt-3 inline-block text-green-600 text-sm font-medium hover:underline">
                            Mulai transaksi sekarang →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <a href="{{ route('kasir.transaksi') }}"
                class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-cash-register text-xl text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Transaksi Baru</h4>
                    <p class="text-sm text-gray-500">Mulai input penjualan sekarang</p>
                </div>
            </a>

            <a href="{{ route('kasir.riwayat_transaksi') }}"
                class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-history text-xl text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Riwayat Transaksi</h4>
                    <p class="text-sm text-gray-500">Lihat semua transaksi saya</p>
                </div>
            </a>
        </div>

    </div>
@endsection
