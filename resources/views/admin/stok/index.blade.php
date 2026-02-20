@extends('admin.layouts.app')
@section('title', 'Stok Produk')
@section('page-description', 'Halaman untuk mengelola stok produk.')

@section('content')
    <!-- Breadcrumb & Header -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="w-4 h-4 mr-2 fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Stok Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <a href="{{ route('admin.stok.create') }}"
                class="flex items-center px-4 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                <i class="mr-2 fas fa-plus"></i>
                Tambah Stok
            </a>
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Produk
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama produk atau kode..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button id="btnFilter"
                class="flex items-center px-4 py-2 text-white transition-all bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="mr-2 fas fa-search"></i> Terapkan
            </button>
            <button id="btnReset"
                class="flex items-center px-4 py-2 text-gray-700 transition-all bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <i class="mr-2 fas fa-redo"></i> Reset
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-boxes"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Stok Produk</h3>
                    <p class="text-sm text-gray-600">Total: <span class="font-semibold text-green-600">5</span> produk</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">No</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Gambar</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Nama Produk</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Stok Saat Ini</th>
                        <th class="px-4 py-3 text-xs font-semibold text-center text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Dummy Row 1 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop"
                                alt="Beras" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Beras Pandan Premium 5kg</div>
                            <div class="text-xs text-gray-500">BRP-001</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600 whitespace-nowrap">120 Kg</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.stok.edit', 1) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Stok">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 2 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=100&h=100&fit=crop"
                                alt="Minyak" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Minyak Goreng Sania 2L</div>
                            <div class="text-xs text-gray-500">MNG-002</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600 whitespace-nowrap">85 Botol</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Stok">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 3 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1556400666-a8c3349b0a4e?w=100&h=100&fit=crop"
                                alt="Gula" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Gula Pasir Gulaku 1kg</div>
                            <div class="text-xs text-gray-500">GLP-003</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-red-600 whitespace-nowrap">8 Sak</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Stok">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 4 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">4</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=100&h=100&fit=crop"
                                alt="Telur" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Telur Ayam Kampung Grade A</div>
                            <div class="text-xs text-gray-500">TLR-004</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600 whitespace-nowrap">320 Butir</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Stok">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 5 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">5</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=100&h=100&fit=crop"
                                alt="Sayur" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Sayur Bayam Organik</div>
                            <div class="text-xs text-gray-500">SAY-005</div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600 whitespace-nowrap">45 Ikat</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Stok">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Dummy Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-5</span> dari <span
                    class="font-semibold text-gray-900">5</span> data
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">
                    1
                </button>
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select All Checkbox
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#tableBody input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        // Live Search 
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }

        // Tombol Terapkan
        const btnFilter = document.getElementById('btnFilter');
        if (btnFilter) {
            btnFilter.addEventListener('click', function() {
                // Bisa ditambah logika filter lain nanti (misal status)
                alert('Filter diterapkan! (live search sudah aktif)');
            });
        }

        // Tombol Reset
        const btnReset = document.getElementById('btnReset');
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                const rows = document.querySelectorAll('#tableBody tr');
                rows.forEach(row => row.style.display = '');
            });
        }
    </script>
@endpush
