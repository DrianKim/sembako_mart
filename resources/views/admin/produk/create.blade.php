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
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Produk Baru</h3>
                    <p class="text-sm text-gray-600">Isi form di bawah untuk menambah produk baru ke dalam daftar</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.produk.store') }}" method="POST" id="formProduk" enctype="multipart/form-data">
            @csrf

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Kode Produk -->
                    <div>
                        <label for="kode_produk" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-barcode"></i>
                            Kode Produk
                        </label>
                        <input type="text" id="kode_produk" name="kode_produk" value="{{ old('kode_produk') }}"
                            placeholder="Contoh: BRP-001 / MNG-002"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('kode_produk') border-red-500 @enderror">
                        @error('kode_produk')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Akan otomatis dibuat jika dikosongkan</p>
                    </div>

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
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
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
                            <option value="1" {{ old('kategori_id') == 1 ? 'selected' : '' }}>Beras & Tepung</option>
                            <option value="2" {{ old('kategori_id') == 2 ? 'selected' : '' }}>Minyak & Mentega</option>
                            <option value="3" {{ old('kategori_id') == 3 ? 'selected' : '' }}>Gula & Pemanis</option>
                            <option value="4" {{ old('kategori_id') == 4 ? 'selected' : '' }}>Buah Segar</option>
                            <option value="5" {{ old('kategori_id') == 5 ? 'selected' : '' }}>Daging Segar</option>
                            <option value="6" {{ old('kategori_id') == 6 ? 'selected' : '' }}>Telur & Produk Unggas</option>
                            <option value="7" {{ old('kategori_id') == 7 ? 'selected' : '' }}>Sayuran Segar</option>
                        </select>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-money-bill-wave"></i>
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="harga" name="harga" required min="1000" step="100"
                            value="{{ old('harga') }}" placeholder="Contoh: 67000"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('harga') border-red-500 @enderror">
                        @error('harga')
                            <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:col-span-2 md:grid-cols-2">
                        <!-- Satuan -->
                        <div>
                            <label for="satuan" class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="mr-1 text-green-600 fas fa-weight-hanging"></i>
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select id="satuan" name="satuan" required
                                class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('satuan') border-red-500 @enderror">
                                <option hidden value="">-- Pilih Satuan --</option>
                                <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                <option value="Botol" {{ old('satuan') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Tray" {{ old('satuan') == 'Tray' ? 'selected' : '' }}>Tray</option>
                                <option value="Pack" {{ old('satuan') == 'Pack' ? 'selected' : '' }}>Pack</option>
                                <option value="Sak" {{ old('satuan') == 'Sak' ? 'selected' : '' }}>Sak</option>
                                <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                            </select>
                            @error('satuan')
                                <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar Produk -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="mr-1 text-green-600 fas fa-image"></i>
                                Gambar Produk
                            </label>
                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 @error('gambar') border-red-500 @enderror">
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                            <div id="imagePreview" class="hidden mt-3">
                                <img id="previewImg" class="object-cover w-32 h-32 rounded-lg shadow" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Pastikan data sudah benar sebelum simpan.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.produk') }}"
                    class="flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-4">
                    <button type="reset" class="px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="mr-2 fas fa-redo"></i> Reset
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700">
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
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    const img = document.getElementById('previewImg');
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto generate kode produk (simplified)
        document.getElementById('nama_produk').addEventListener('blur', function() {
            const kodeInput = document.getElementById('kode_produk');
            if (!kodeInput.value.trim()) {
                const nama = this.value.trim();
                if (nama) {
                    const words = nama.split(/\s+/).slice(0, 3);
                    let prefix = words.map(w => w.charAt(0).toUpperCase()).join('');
                    if (prefix.length < 3) prefix += 'X'.repeat(3 - prefix.length);
                    const num = Math.floor(Math.random() * 900 + 100);
                    kodeInput.value = `${prefix}-${num}`;
                }
            }
        });
    </script>
@endpush
