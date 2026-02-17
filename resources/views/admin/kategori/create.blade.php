@extends('admin.layouts.app')
@section('title', 'Tambah Kategori')
@section('page-description', 'Halaman untuk menambah kategori produk baru.')

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
                    <a href="{{ route('admin.kategori') }}"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 md:ml-2">
                        Kategori Produk
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Kategori</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
            <div class="flex items-center">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 bg-green-100 rounded-lg">
                    <i class="text-2xl text-green-600 fas fa-plus-circle"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Tambah Kategori Baru</h3>
                    <p class="text-sm text-gray-600">Isi form di bawah untuk menambah kategori baru</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form action="{{ route('admin.kategori.store') }}" method="POST" id="formKategori">
            @csrf

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Kode Kategori -->
                    <div class="md:col-span-2">
                        <label for="kode_kategori" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-barcode"></i>
                            Kode Kategori
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="kode_kategori" name="kode_kategori"
                            value="{{ old('kode_kategori') }}"
                            placeholder="Contoh: KTG-001"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('kode_kategori') border-red-500 @enderror"
                            required>
                        @error('kode_kategori')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="mr-1 fas fa-info-circle"></i>
                            Kode unik untuk kategori (otomatis jika dikosongkan)
                        </p>
                    </div>

                    <!-- Nama Kategori -->
                    <div class="md:col-span-2">
                        <label for="nama_kategori" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-tag"></i>
                            Nama Kategori
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_kategori" name="nama_kategori"
                            value="{{ old('nama_kategori') }}"
                            placeholder="Masukkan nama kategori"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('nama_kategori') border-red-500 @enderror"
                            required>
                        @error('nama_kategori')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-align-left"></i>
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Masukkan deskripsi kategori (opsional)"
                            class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Icon Kategori -->
                    <div>
                        <label for="icon" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-icons"></i>
                            Icon Kategori
                        </label>
                        <div class="relative">
                            <select id="icon" name="icon"
                                class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none @error('icon') border-red-500 @enderror">
                                <option value="">Pilih Icon</option>
                                <option value="fa-rice" {{ old('icon') == 'fa-rice' ? 'selected' : '' }}>🌾 Beras</option>
                                <option value="fa-oil-can" {{ old('icon') == 'fa-oil-can' ? 'selected' : '' }}>🛢️ Minyak</option>
                                <option value="fa-cube" {{ old('icon') == 'fa-cube' ? 'selected' : '' }}>🧊 Gula</option>
                                <option value="fa-pepper-hot" {{ old('icon') == 'fa-pepper-hot' ? 'selected' : '' }}>🌶️ Bumbu</option>
                                <option value="fa-cookie-bite" {{ old('icon') == 'fa-cookie-bite' ? 'selected' : '' }}>🍪 Makanan Ringan</option>
                                <option value="fa-coffee" {{ old('icon') == 'fa-coffee' ? 'selected' : '' }}>☕ Minuman</option>
                                <option value="fa-bread-slice" {{ old('icon') == 'fa-bread-slice' ? 'selected' : '' }}>🍞 Roti</option>
                                <option value="fa-soap" {{ old('icon') == 'fa-soap' ? 'selected' : '' }}>🧼 Perlengkapan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('icon')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <!-- Icon Preview -->
                        <div class="flex items-center justify-center w-full p-4 mt-3 border-2 border-gray-200 border-dashed rounded-lg bg-gray-50">
                            <div class="text-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-2 bg-green-100 rounded-lg">
                                    <i id="iconDisplay" class="text-2xl text-green-600 fas fa-icons"></i>
                                </div>
                                <p class="text-sm text-gray-600">Preview Icon</p>
                            </div>
                        </div>
                    </div>

                    <!-- Warna Kategori -->
                    <div>
                        <label for="warna" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-palette"></i>
                            Warna Kategori
                        </label>
                        <div class="relative">
                            <select id="warna" name="warna"
                                class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none @error('warna') border-red-500 @enderror">
                                <option value="">Pilih Warna</option>
                                <option value="green" {{ old('warna') == 'green' ? 'selected' : '' }}>🟢 Hijau</option>
                                <option value="orange" {{ old('warna') == 'orange' ? 'selected' : '' }}>🟠 Orange</option>
                                <option value="blue" {{ old('warna') == 'blue' ? 'selected' : '' }}>🔵 Biru</option>
                                <option value="red" {{ old('warna') == 'red' ? 'selected' : '' }}>🔴 Merah</option>
                                <option value="purple" {{ old('warna') == 'purple' ? 'selected' : '' }}>🟣 Ungu</option>
                                <option value="cyan" {{ old('warna') == 'cyan' ? 'selected' : '' }}>🔷 Cyan</option>
                                <option value="yellow" {{ old('warna') == 'yellow' ? 'selected' : '' }}>🟡 Kuning</option>
                                <option value="pink" {{ old('warna') == 'pink' ? 'selected' : '' }}>🩷 Pink</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="text-gray-400 fas fa-chevron-down"></i>
                            </div>
                        </div>
                        @error('warna')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        <!-- Color Preview -->
                        <div class="flex items-center justify-center w-full p-4 mt-3 border-2 border-gray-200 border-dashed rounded-lg bg-gray-50">
                            <div class="text-center">
                                <div id="colorDisplay" class="w-16 h-16 mx-auto mb-2 border-4 border-white rounded-lg shadow-md bg-gradient-to-br from-green-400 to-green-600">
                                </div>
                                <p class="text-sm text-gray-600">Preview Warna</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label for="status" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="mr-1 text-green-600 fas fa-toggle-on"></i>
                            Status
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="status" value="1" checked
                                    class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">
                                    <i class="mr-1 text-green-600 fas fa-check-circle"></i>
                                    Aktif
                                </span>
                            </label>
                            <label class="flex items-center px-4 py-3 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="status" value="0"
                                    class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">
                                    <i class="mr-1 text-red-600 fas fa-times-circle"></i>
                                    Nonaktif
                                </span>
                            </label>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">
                                <i class="mr-1 fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Alert Info -->
                <div class="p-4 mt-6 border-l-4 border-green-500 rounded-lg bg-green-50">
                    <div class="flex items-start">
                        <i class="mt-1 mr-3 text-green-600 fas fa-info-circle"></i>
                        <div>
                            <p class="text-sm font-semibold text-green-800">Informasi</p>
                            <p class="text-sm text-green-700">
                                Pastikan data yang Anda masukkan sudah benar. Field yang bertanda
                                <span class="text-red-500">*</span> wajib diisi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.kategori') }}"
                    class="flex items-center px-5 py-2.5 text-gray-700 transition-all duration-200 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <i class="mr-2 fas fa-arrow-left"></i>
                    Kembali
                </a>
                <div class="flex gap-3">
                    <button type="reset"
                        class="flex items-center px-5 py-2.5 text-gray-700 transition-all duration-200 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <i class="mr-2 fas fa-redo"></i>
                        Reset
                    </button>
                    <button type="submit"
                        class="flex items-center px-5 py-2.5 text-white transition-all duration-200 bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="mr-2 fas fa-save"></i>
                        Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Icon Preview
        document.getElementById('icon').addEventListener('change', function() {
            const iconClass = this.value || 'fa-icons';
            document.getElementById('iconDisplay').className = `text-2xl text-green-600 fas ${iconClass}`;
        });

        // Color Preview
        document.getElementById('warna').addEventListener('change', function() {
            const color = this.value;
            const colorDisplay = document.getElementById('colorDisplay');
            
            const colorMap = {
                'green': 'from-green-400 to-green-600',
                'orange': 'from-orange-400 to-orange-600',
                'blue': 'from-blue-400 to-blue-600',
                'red': 'from-red-400 to-red-600',
                'purple': 'from-purple-400 to-purple-600',
                'cyan': 'from-cyan-400 to-cyan-600',
                'yellow': 'from-yellow-400 to-yellow-600',
                'pink': 'from-pink-400 to-pink-600'
            };

            // Remove all color classes
            colorDisplay.className = 'w-16 h-16 mx-auto mb-2 border-4 border-white rounded-lg shadow-md bg-gradient-to-br';
            
            // Add selected color class
            if (colorMap[color]) {
                colorDisplay.classList.add(...colorMap[color].split(' '));
            } else {
                colorDisplay.classList.add('from-green-400', 'to-green-600');
            }
        });

        // Form Validation
        document.getElementById('formKategori').addEventListener('submit', function(e) {
            const namaKategori = document.getElementById('nama_kategori').value.trim();
            
            if (!namaKategori) {
                e.preventDefault();
                alert('Nama kategori wajib diisi!');
                document.getElementById('nama_kategori').focus();
                return false;
            }
        });

        // Auto-generate Kode Kategori
        document.getElementById('nama_kategori').addEventListener('blur', function() {
            const kodeInput = document.getElementById('kode_kategori');
            
            if (!kodeInput.value) {
                const nama = this.value.trim();
                if (nama) {
                    // Generate kode from nama (contoh: "Beras & Tepung" -> "KTG-BT")
                    const words = nama.split(/[\s&]+/);
                    const initials = words.map(word => word.charAt(0).toUpperCase()).join('');
                    const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
                    kodeInput.value = `KTG-${initials}${randomNum}`;
                }
            }
        });
    </script>
@endpush