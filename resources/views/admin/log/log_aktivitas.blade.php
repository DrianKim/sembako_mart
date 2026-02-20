@extends('admin.layouts.app')
@section('title', 'Log Aktivitas')
@section('page-description', 'Riwayat aktivitas Anda sebagai admin.')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Log Aktivitas</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Aktivitas
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan deskripsi aktivitas..."
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button id="btnFilter"
                class="flex items-center px-4 py-2 text-white transition-all duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="mr-2 fas fa-search"></i>
                Terapkan
            </button>
            <button id="btnReset"
                class="flex items-center px-4 py-2 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <i class="mr-2 fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Table Header with Info -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-history"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Aktivitas Saya</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">8</span> aktivitas</p>
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
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Aktivitas
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Waktu
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Dummy Row 1 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">User 'Admin Sembako Mart' melakukan login sebagai Admin</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 08:03:32</td>
                    </tr>

                    <!-- Dummy Row 2 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Menambahkan produk baru: Beras Pandan Premium 5kg (BRP-001)
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 09:15:47</td>
                    </tr>

                    <!-- Dummy Row 3 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Mengedit stok produk: Minyak Goreng Sania 2L +100 Botol</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 10:22:19</td>
                    </tr>

                    <!-- Dummy Row 4 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">4</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Menambahkan kasir baru: Siti Rahayu (siti_kasir01)</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 11:45:03</td>
                    </tr>

                    <!-- Dummy Row 5 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">5</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Mengubah status kasir Budi Santoso menjadi Nonaktif</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 13:10:55</td>
                    </tr>

                    <!-- Dummy Row 6 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">6</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Melakukan logout dari sistem</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 18:30:12</td>
                    </tr>

                    <!-- Dummy Row 7 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">7</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">User 'Admin Sembako Mart' melakukan login kembali</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-21 07:45:28</td>
                    </tr>

                    <!-- Dummy Row 8 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">8</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Menambahkan kategori baru: Buah Segar (KTG-004)</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-21 09:12:41</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-8</span> dari <span
                    class="font-semibold text-gray-900">8</span> aktivitas
            </div>
            <div class="flex items-center gap-2">
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fas fa-chevron-left"></i>
                    Previous
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
                    Next
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions (dummy, meski log ga perlu hapus) -->
    <div id="bulkActions"
        class="fixed bottom-0 left-0 right-0 z-50 hidden p-4 transition-all duration-300 transform translate-y-full bg-white border-t-2 border-green-500 shadow-2xl">
        <div class="container flex items-center justify-between mx-auto">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-green-600 fas fa-check-circle"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">
                    <span id="selectedCount">0</span> aktivitas dipilih
                </span>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center px-4 py-2 text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                    <i class="mr-2 fas fa-trash"></i>
                    Hapus Terpilih
                </button>
                <button
                    class="flex items-center px-4 py-2 text-gray-700 transition-colors bg-gray-200 rounded-lg hover:bg-gray-300">
                    <i class="mr-2 fas fa-times"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Live Search
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Reset functionality
        document.getElementById('btnReset').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('#tableBody tr').forEach(row => {
                row.style.display = '';
            });
        });
    </script>
@endpush
