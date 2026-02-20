@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('page-description', 'Halaman untuk mengedit data produk.')

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

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-edit"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Edit Produk: Beras Pandan Premium 5kg</h3>
                    <p class="text-sm text-gray-600">Kode: BRP-001 | Kategori: Beras & Tepung</p>
                </div>
            </div>
        </div>

        <form action="#" method="POST" id="formProduk" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Kode Produk (readonly) -->
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-barcode"></i>
                            Kode Produk
                        </label>
                        <input type="text" value="BRP-001"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed"
                            readonly>
                        <p class="mt-1 text-xs text-gray-500">Kode produk tidak dapat diubah</p>
                    </div>

                    <!-- Nama Produk -->
                    <div class="md:col-span-2">
                        <label for="nama_produk" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-tag"></i>
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" required value="Beras Pandan Premium 5kg"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-layer-group"></i>
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="kategori_id" name="kategori_id" required
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                            <option hidden value="">-- Pilih Kategori --</option>
                            <option value="1" selected>Beras & Tepung</option>
                            <option value="2">Minyak & Mentega</option>
                            <option value="3">Gula & Pemanis</option>
                            <option value="4">Buah Segar</option>
                            <option value="5">Daging Segar</option>
                            <option value="6">Telur & Produk Unggas</option>
                            <option value="7">Sayuran Segar</option>
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-money-bill-wave"></i>
                            Harga (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="harga" name="harga" required min="1000" step="100"
                            value="78000"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Satuan + Gambar (dibarengin di satu row) -->
                    <div class="grid grid-cols-1 gap-6 md:col-span-2 md:grid-cols-2">
                        <!-- Satuan -->
                        <div>
                            <label for="satuan" class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="mr-1 text-green-600 fas fa-weight-hanging"></i>
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select id="satuan" name="satuan" required
                                class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                                <option hidden value="">-- Pilih Satuan --</option>
                                <option value="Kg" selected>Kg</option>
                                <option value="Botol">Botol</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Tray">Tray</option>
                                <option value="Pack">Pack</option>
                                <option value="Sak">Sak</option>
                                <option value="Liter">Liter</option>
                            </select>
                        </div>

                        <!-- Gambar Produk -->
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="mr-1 text-green-600 fas fa-image"></i>
                                Gambar Produk
                            </label>
                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                class="block w-full text-sm text-gray-700 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <!-- Preview Gambar Saat Ini (dummy) -->
                            <div class="mt-3">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=300&h=300&fit=crop"
                                    alt="Preview Gambar Saat Ini" class="object-cover w-32 h-32 rounded-lg shadow">
                                <p class="mt-1 text-xs text-gray-500">Gambar saat ini. Upload baru jika ingin mengganti.</p>
                            </div>
                            <!-- Preview Gambar Baru -->
                            <div id="imagePreview" class="hidden mt-3">
                                <img id="previewImg" class="object-cover w-32 h-32 rounded-lg shadow" alt="Preview">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-4 mt-8 border-l-4 border-green-500 rounded bg-green-50">
                    <p class="text-sm text-green-800">
                        <i class="mr-2 fas fa-info-circle"></i>
                        Mengedit produk hanya mempengaruhi informasi dasar. Stok dan transaksi tidak berubah otomatis.
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
                        <i class="mr-2 fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview Gambar Baru
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
    </script>
@endpush
