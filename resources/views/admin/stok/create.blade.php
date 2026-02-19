@extends('admin.layouts.app')
@section('title', 'Tambah Stok Produk')
@section('page-description', 'Halaman untuk menambah stok produk yang sudah ada.')

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
                    <a href="{{ route('admin.stok') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Stok Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Stok</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Stok Produk</h3>
                    <p class="text-sm text-gray-600">Pilih produk dan masukkan jumlah stok yang akan ditambahkan</p>
                </div>
            </div>
        </div>

        <form action="#" method="POST" id="formStok">
            @csrf

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Pilih Produk (dummy) -->
                    <div class="md:col-span-2">
                        <label for="produk_id" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-box"></i>
                            Produk <span class="text-red-500">*</span>
                        </label>
                        <select id="produk_id" name="produk_id" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option value="">-- Pilih Produk --</option>
                            <option value="1">Beras Pandan Premium 5kg (BRP-001) - Stok saat ini: 120 Kg</option>
                            <option value="2">Minyak Goreng Sania 2L (MNG-002) - Stok saat ini: 85 Botol</option>
                            <option value="3">Gula Pasir Gulaku 1kg (GLP-003) - Stok saat ini: 8 Sak</option>
                            <option value="4">Telur Ayam Kampung Grade A (TLR-004) - Stok saat ini: 320 Butir</option>
                            <option value="5">Sayur Bayam Organik (SAY-005) - Stok saat ini: 45 Ikat</option>
                            <!-- Produk stok 0 tidak muncul di dropdown ini (sesuai konsep) -->
                        </select>
                    </div>

                    <!-- Jumlah Stok Ditambahkan -->
                    <div>
                        <label for="stok" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-plus-square"></i>
                            Jumlah Stok Ditambahkan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stok" name="stok" required min="1" step="1"
                            value="50" placeholder="Contoh: 50"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <p class="mt-1 text-xs text-gray-500">Masukkan jumlah stok yang ingin ditambahkan (positif)</p>
                    </div>

                    <!-- Preview Stok Saat Ini (dummy via JS) -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-info-circle"></i>
                            Stok Saat Ini
                        </label>
                        <div id="currentStok"
                            class="px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-medium">
                            Pilih produk terlebih dahulu...
                        </div>
                    </div>

                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Stok akan ditambahkan ke stok saat ini. Field bertanda <span class="text-red-500">*</span> wajib
                        diisi.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.stok') }}"
                    class="flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset" class="px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                        <i class="mr-2 fas fa-plus"></i> Tambah Stok
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const produkSelect = document.getElementById('produk_id');
        const currentStokDiv = document.getElementById('currentStok');

        produkSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (selected.value) {
                const stokMatch = selected.textContent.match(/Stok saat ini: (\d+)/);
                const stok = stokMatch ? stokMatch[1] : '0';
                const satuan = selected.textContent.split('Stok saat ini:')[1]?.split(' ')[2] || '';
                currentStokDiv.innerHTML = `<span class="font-bold text-green-600">${stok}</span> ${satuan}`;
            } else {
                currentStokDiv.textContent = 'Pilih produk terlebih dahulu...';
            }
        });
    </script>
@endpush
