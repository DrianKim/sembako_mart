@extends('admin.layouts.app')
@section('title', 'Tambah Produk')
@section('page-description', 'Halaman untuk menambah produk baru.')

@section('content')
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                    <i class="w-4 h-4 mr-2 fas fa-home"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <a href="{{ route('admin.produk') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">
                        Produk
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Produk</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="overflow-hidden bg-white border border-gray-200 shadow-md rounded-xl">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 shadow-sm rounded-xl">
                    <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Produk Baru</h3>
                    <p class="mt-1 text-sm text-gray-600">Isi form di bawah untuk menambah produk ke dalam daftar</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.produk.store') }}" method="POST" id="formProduk" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nama Produk -->
                    <div>
                        <label for="nama_produk" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-tag"></i>
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" required value="{{ old('nama_produk') }}"
                            placeholder="Contoh: Beras Pandan Premium 5kg"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nama_produk') border-red-500 @enderror">
                        @error('nama_produk')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barcode -->
                    <div>
                        <label for="barcode" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-barcode"></i>
                            Barcode
                        </label>
                        <input type="text" id="barcode" name="barcode" value="{{ old('barcode') }}"
                            placeholder="Contoh: 8993169411108"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('barcode') border-red-500 @enderror">
                        @error('barcode')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-layer-group"></i>
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori_id" name="kategori_id" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('kategori_id') border-red-500 @enderror">
                            <option hidden value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-weight-hanging"></i>
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select id="satuan" name="satuan" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('satuan') border-red-500 @enderror">
                            <option hidden value="">-- Pilih Satuan --</option>
                            <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                            <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>liter</option>
                        </select>
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Batch --}}
                    <div>
                        <label for="nomor_batch" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-hashtag"></i>
                            Nomor Batch
                        </label>
                        <input type="text" id="nomor_batch" name="nomor_batch" value="{{ old('nomor_batch') }}"
                            placeholder="Contoh: BATCH-2025-001"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nomor_batch') border-red-500 @enderror">
                        @error('nomor_batch')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stok Awal --}}
                    <div>
                        <label for="stok_awal" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-boxes"></i>
                            Stok Awal <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stok_awal" name="stok_awal" required min="0"
                            value="{{ old('stok_awal') }}" placeholder="Contoh: 100"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('stok_awal') border-red-500 @enderror">
                        @error('stok_awal')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga Beli --}}
                    <div>
                        <label for="harga_beli" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-coins"></i>
                            Harga Beli (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="harga_beli" name="harga_beli" required min="0" step="100"
                            value="{{ old('harga_beli') }}" placeholder="Contoh: 70000"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('harga_beli') border-red-500 @enderror">
                        @error('harga_beli')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Kadaluarsa --}}
                    <div>
                        <label for="tanggal_kadaluarsa" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-calendar-times"></i>
                            Tanggal Kadaluarsa
                        </label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                            value="{{ old('tanggal_kadaluarsa') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('tanggal_kadaluarsa') border-red-500 @enderror">
                        @error('tanggal_kadaluarsa')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div>
                        <label for="harga_jual" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-money-bill-wave"></i>
                            Harga Jual (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="harga_jual" name="harga_jual" required min="0" step="100"
                            value="{{ old('harga_jual') }}" placeholder="Contoh: 78000"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('harga_jual') border-red-500 @enderror">
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-image"></i>
                            Gambar Produk
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 @error('foto') border-red-500 @enderror">
                        @error('foto')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="hidden mt-3">
                            <img id="previewImg" class="object-cover w-32 h-32 rounded-lg shadow" alt="Preview">
                        </div>
                    </div>
                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Pastikan harga jual lebih
                        tinggi
                        dari harga beli.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-5 border-t bg-gray-50">
                <a href="{{ route('admin.produk') }}"
                    class="flex items-center px-6 py-3 transition bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset"
                        class="px-6 py-3 transition bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white transition rounded-lg shadow-md bg-gradient-to-r from-green-600 to-green-500 hover:shadow-lg hover:from-green-700 hover:to-green-600">
                        <i class="mr-2 fas fa-save"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview Gambar
        document.getElementById('foto')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Validasi harga jual > harga beli
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                const hargaJual = document.getElementById('harga_jual');
                const hargaBeli = document.getElementById('harga_beli');
                if (hargaJual.value && hargaBeli.value && parseFloat(hargaJual.value) <= parseFloat(
                        hargaBeli.value)) {
                    hargaJual.style.borderColor = '#ef4444';
                    this.style.borderColor = '#10b981';
                } else {
                    hargaJual.style.borderColor = '';
                    hargaBeli.style.borderColor = '';
                }
            });
        });
    </script>
@endpush
