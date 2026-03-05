@extends('owner.layouts.app')
@section('title', 'Produk')
@section('page-description', 'Lihat daftar produk dan stok saat ini.')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Breadcrumb -->
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('owner.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="w-4 h-4 mr-2 fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:gap-4">
            <!-- Search - span 3 biar lebar dominan -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Produk
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama, barcode, atau kategori..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Reset - satu jajar nempel di kanan search, ga jauh -->
            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm">
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Table Header with Info -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">8</span> produk</p>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="p-2 text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-green-600"
                    title="Export Excel">
                    <i class="fas fa-file-excel"></i>
                </button>
                <button class="p-2 text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-green-600"
                    title="Export PDF">
                    <i class="fas fa-file-pdf"></i>
                </button>
                <button class="p-2 text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-green-600"
                    title="Print">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            No
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Gambar
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Nama Produk
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Kategori
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Harga
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Satuan
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            Stok Saat Ini
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Dummy Row 1 (stok >10 → hijau) -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop"
                                alt="Beras Pandan" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Beras Pandan Premium 5kg</div>
                            <div class="text-xs text-gray-500">Barcode: BRP-001</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Beras & Tepung</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">Rp 78.000</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">kg</td>
                        <td class="px-6 py-4 font-bold text-center text-green-600 whitespace-nowrap">
                            45
                        </td>
                    </tr>

                    <!-- Dummy Row 2 (stok ≤10 & >0 → kuning) -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1626957341926-98752fc2ba90?w=100&h=100&fit=crop"
                                alt="Minyak" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Minyak Goreng Sania 2L</div>
                            <div class="text-xs text-gray-500">Barcode: MNG-002</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Minyak & Mentega</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">Rp 42.500</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">liter</td>
                        <td class="px-6 py-4 font-bold text-center text-yellow-600 whitespace-nowrap">
                            8
                        </td>
                    </tr>

                    <!-- Dummy Row 3 (stok 0 → merah + Habis) -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="https://images.unsplash.com/photo-1556400666-a8c3349b0a4e?w=100&h=100&fit=crop"
                                alt="Gula" class="object-cover w-10 h-10 rounded">
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Gula Pasir Gulaku 1kg</div>
                            <div class="text-xs text-gray-500">Barcode: GLP-003</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Gula & Pemanis</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">Rp 18.000</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">kg</td>
                        <td class="px-6 py-4 font-bold text-center text-red-600 whitespace-nowrap">
                            0 (Habis)
                        </td>
                    </tr>

                    <!-- Tambah dummy lain kalau mau -->
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-3</span> dari <span
                    class="font-semibold text-gray-900">8</span> produk
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">
                    1
                </button>
                <button
                    class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    2
                </button>
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Live Search
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // Reset
        document.getElementById('btnReset')?.addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('#tableBody tr').forEach(row => row.style.display = '');
        });

        // Terapkan (dummy, karena live search sudah aktif)
        document.getElementById('btnFilter')?.addEventListener('click', function() {
            alert('Filter diterapkan! (live search sudah aktif)');
        });
    </script>
@endpush
