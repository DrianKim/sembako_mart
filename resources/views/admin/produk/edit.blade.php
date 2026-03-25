@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('page-description', 'Halaman untuk mengedit data produk.')

@section('content')
    <!-- Breadcrumb -->
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
                    <a href="{{ route('admin.produk') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Produk</span>
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
                    <i class="text-2xl text-green-600 fas fa-edit"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Produk: {{ $produk->nama_produk }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Kode: {{ $produk->barcode ?? 'BRS-00' . str_pad($produk->id, 3, '0', STR_PAD_LEFT) }} |
                        Satuan: {{ $produk->satuan ?? 'kg' }}
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" id="formProduk"
            enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nama Produk -->
                    <div>
                        <label for="nama_produk" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-tag"></i>
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" required
                            value="{{ old('nama_produk', $produk->nama_produk) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nama_produk') border-red-500 @enderror">
                        @error('nama_produk')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Barcode -->
                    <div>
                        <label for="barcode" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-barcode"></i>
                            Barcode
                        </label>
                        <input type="text" id="barcode" name="barcode" value="{{ old('barcode', $produk->barcode) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('barcode') border-red-500 @enderror">
                        @error('barcode')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
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
                                    {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Beli -->
                    <div>
                        <label for="harga_beli" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-coins"></i>
                            Harga Beli (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="harga_beli" name="harga_beli" required min="0" step="100"
                            value="{{ old('harga_beli', $produk->harga_beli) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all @error('harga_beli') border-red-500 @enderror">
                        @error('harga_beli')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
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
                            <option value="kg" {{ old('satuan', $produk->satuan) == 'kg' ? 'selected' : '' }}>kg
                            </option>
                            <option value="pcs" {{ old('satuan', $produk->satuan) == 'pcs' ? 'selected' : '' }}>pcs
                            </option>
                            <option value="liter" {{ old('satuan', $produk->satuan) == 'liter' ? 'selected' : '' }}>liter
                            </option>
                        </select>
                        @error('satuan')
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
                            value="{{ old('harga_jual', $produk->harga_jual) }}"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('harga_jual') border-red-500 @enderror">
                        @error('harga_jual')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar Produk -->
                    <div>
                        <label for="foto" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-image"></i>
                            Gambar Produk
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 @error('foto') border-red-500 @enderror">
                        @error('foto')
                            <p class="mt-1 text-sm text-red-500"><i
                                    class="mr-1 fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror

                        <!-- SELALU TAMPIL: Gambar Saat Ini -->
                        @if ($produk->foto)
                            <div class="flex items-center gap-3 mt-3">
                                <div>
                                    <img src="https://yexkxhepiviphofpsymz.supabase.co/storage/v1/object/public/{{ $produk->foto }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="object-cover w-24 h-24 rounded-lg shadow">
                                </div>
                                <span class="text-xs text-gray-500">Saat ini</span>
                            </div>
                        @endif

                        <!-- HANYA MUNCUL pas pilih file BARU -->
                        <div id="imagePreview" class="flex items-center hidden gap-3 mt-4">
                            <img id="previewImg" class="object-cover w-24 h-24 rounded-lg shadow" alt="Preview">
                            <span class="text-xs font-medium text-blue-600">Preview baru</span>
                        </div>
                    </div>

                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Field bertanda <span class="text-red-500">*</span> wajib diisi. Pastikan harga jual lebih tinggi
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
                        <i class="mr-2 fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Preview Gambar + HIDE foto lama
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Show preview baru
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');

                    // HIDE foto saat ini
                    const currentImage = document.querySelector('.flex.items-center.gap-3.mt-3');
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Validasi harga jual > harga beli (tetep sama)
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                const hargaJual = document.getElementById('harga_jual');
                const hargaBeli = document.getElementById('harga_beli');
                if (hargaJual.value && hargaBeli.value && parseFloat(hargaJual.value) <= parseFloat(
                        hargaBeli.value)) {
                    hargaJual.style.borderColor = '#ef4444';
                    hargaBeli.style.borderColor = '#10b981';
                } else {
                    hargaJual.style.borderColor = '';
                    hargaBeli.style.borderColor = '';
                }
            });
        });
    </script>
@endpush
