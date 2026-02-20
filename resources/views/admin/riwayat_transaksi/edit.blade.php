@extends('admin.layouts.app')
@section('title', 'Edit Transaksi')
@section('page-description', 'Halaman untuk mengedit data transaksi.')

@section('content')
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                    <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <a href="{{ route('admin.riwayat_transaksi') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Riwayat Transaksi</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Transaksi</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-edit"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Transaksi #TRX-20260220-001</h3>
                    <p class="text-sm text-gray-600">Tanggal: 2026-02-20 14:45:00 | Kasir: andi_kasir</p>
                </div>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Nama Pelanggan -->
                    <div>
                        <label for="nama_pelanggan" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-user"></i>
                            Nama Pelanggan
                        </label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="Budi"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Nomor Unik (readonly) -->
                    <div>
                        <label for="nomor_unik" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-hashtag"></i>
                            Nomor Unik
                        </label>
                        <input type="text" id="nomor_unik" name="nomor_unik" value="TRX-20260220-001" readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                    </div>

                    <!-- Total Harga -->
                    <div>
                        <label for="total_harga" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-money-bill-wave"></i>
                            Total Harga <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="total_harga" name="total_harga" value="185000" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Uang Bayar -->
                    <div>
                        <label for="uang_bayar" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-hand-holding-usd"></i>
                            Uang Bayar
                        </label>
                        <input type="number" id="uang_bayar" name="uang_bayar" value="200000"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Uang Kembali -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-calculator"></i>
                            Uang Kembali
                        </label>
                        <input type="text" id="uang_kembali" value="Rp 15.000" readonly
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                    </div>

                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Edit transaksi hanya untuk koreksi data. Perubahan stok produk tidak otomatis dikembalikan.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.riwayat_transaksi') }}"
                    class="flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset" class="px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                        <i class="mr-2 fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Hitung uang kembali secara real-time (dummy)
        const totalInput = document.getElementById('total_harga');
        const bayarInput = document.getElementById('uang_bayar');
        const kembaliInput = document.getElementById('uang_kembali');

        function hitungKembali() {
            const total = parseFloat(totalInput.value) || 0;
            const bayar = parseFloat(bayarInput.value) || 0;
            const kembali = bayar - total;
            kembaliInput.value = kembali >= 0 ? 'Rp ' + kembali.toLocaleString('id-ID') : 'Uang tidak cukup';
        }

        totalInput?.addEventListener('input', hitungKembali);
        bayarInput?.addEventListener('input', hitungKembali);
        hitungKembali(); // Init
    </script>
@endpush
