@extends('admin.layouts.app')
@section('title', 'Data Kasir')
@section('page-description', 'Halaman untuk mengelola data kasir.')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Kasir</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <a href="{{ route('admin.kasir.create') }}"
                class="flex items-center px-4 py-2.5 text-white transition-all duration-200 bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="mr-2 fas fa-plus"></i>
                Tambah Kasir
            </a>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Kasir
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama, username atau nomor HP..."
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-filter"></i>
                    Status
                </label>
                <select id="statusFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>

        <!-- Filter Actions -->
        <div class="flex gap-3 mt-4">
            <button id="btnFilter"
                class="flex items-center px-4 py-2 text-white transition-all duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="mr-2 fas fa-search"></i>
                Terapkan Filter
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
                    <i class="text-xl text-green-600 fas fa-user-tie"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Kasir</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">6</span> kasir</p>
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
                            Nama
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Username
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            No HP
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            Status
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Dummy Row 1 - Aktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Andi Susanto</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">andi_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">081234567890</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.kasir.edit', 1) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 2 - Aktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Siti Rahayu</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">siti_kasir01</td>
                        <td class="px-6 py-4 text-sm text-gray-900">08567891234</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 3 - Nonaktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Budi Santoso</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">budi_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">087654321098</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                Nonaktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 4 - Aktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">4</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Dewi Lestari</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">dewi_kasir02</td>
                        <td class="px-6 py-4 text-sm text-gray-900">089876543210</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 5 - Nonaktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">5</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Rudi Hartono</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">rudi_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">08111222333</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                Nonaktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 6 - Aktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">6</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Lina Marlina</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">lina_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">082345678901</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-6</span> dari <span
                    class="font-semibold text-gray-900">6</span> data
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
                    class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    3
                </button>
                <button
                    class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Next
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions (shown when items selected) -->
    <div id="bulkActions"
        class="fixed bottom-0 left-0 right-0 z-50 hidden p-4 transition-all duration-300 transform translate-y-full bg-white border-t-2 border-green-500 shadow-2xl">
        <div class="container flex items-center justify-between mx-auto">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-green-600 fas fa-check-circle"></i>
                </div>
                <span class="text-sm font-semibold text-gray-800">
                    <span id="selectedCount">0</span> item dipilih
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
        // Select All Checkbox
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#tableBody input[type="checkbox"]');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateBulkActions();
            });
        }

        // Individual Checkboxes for bulk actions
        document.querySelectorAll('#tableBody input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('#tableBody input[type="checkbox"]:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (selectedCount) selectedCount.textContent = checkedBoxes.length;

            if (checkedBoxes.length > 0) {
                bulkActions.classList.remove('hidden', 'translate-y-full');
            } else {
                bulkActions.classList.add('translate-y-full');
                setTimeout(() => bulkActions.classList.add('hidden'), 300);
            }
        }

        // Live Search (real-time)
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                applyFilters();
            });
        }

        // Status Filter + Search combined
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                applyFilters();
            });
        }

        function applyFilters() {
            const searchTerm = (searchInput ? searchInput.value.toLowerCase().trim() : '');
            const statusVal = (statusFilter ? statusFilter.value.toLowerCase() : '');
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const statusBadge = row.querySelector('td:nth-child(5) span')?.textContent.toLowerCase().trim() ||
                    '';

                const matchSearch = rowText.includes(searchTerm);
                const matchStatus = statusVal === '' || statusBadge.includes(statusVal);

                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }

        // Tombol Terapkan (manual trigger filter)
        const btnFilter = document.getElementById('btnFilter');
        if (btnFilter) {
            btnFilter.addEventListener('click', applyFilters);
        }

        // Tombol Reset (bersihin semua filter)
        const btnReset = document.getElementById('btnReset');
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (statusFilter) statusFilter.value = '';
                applyFilters();
            });
        }
    </script>
@endpush
