@extends('admin.layouts.app')
@section('title', 'Kategori Produk')
@section('page-description', 'Halaman untuk mengelola kategori produk.')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Breadcrumb -->
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Kategori Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Create Button -->
            <a href="{{ route('admin.kategori.create') }}"
                class="flex items-center px-4 py-2.5 text-white transition-all duration-200 bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kategori
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
                    Cari Kategori
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama atau deskripsi..."
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
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
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Kategori</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">8</span> kategori</p>
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
                            <input type="checkbox" id="selectAll"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </th>
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Nama Kategori
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Row 1 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 whitespace-nowrap">
                            <input type="checkbox"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </td>
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-green-100 rounded-lg">
                                    <i class="text-green-600 fas fa-rice"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">Beras & Tepung</div>
                                    <div class="text-xs text-gray-500">Kode: KTG-001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.kategori.edit', 1) }}" class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 whitespace-nowrap">
                            <input type="checkbox"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </td>
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-orange-100 rounded-lg">
                                    <i class="text-orange-600 fas fa-oil-can"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">Minyak & Mentega</div>
                                    <div class="text-xs text-gray-500">Kode: KTG-002</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <button class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 whitespace-nowrap">
                            <input type="checkbox"
                                class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </td>
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div
                                    class="flex items-center justify-center flex-shrink-0 w-10 h-10 mr-3 bg-yellow-100 rounded-lg">
                                    <i class="text-yellow-600 fas fa-bread-slice"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">Roti & Kue</div>
                                    <div class="text-xs text-gray-500">Kode: KTG-007</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <button class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-8</span> dari <span
                    class="font-semibold text-gray-900">8</span> data
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

    <!-- Bulk Actions -->
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
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual Checkboxes
        document.querySelectorAll('tbody input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('tbody input[type="checkbox"]:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = checkedBoxes.length;

            if (checkedBoxes.length > 0) {
                bulkActions.classList.remove('hidden', 'translate-y-full');
            } else {
                bulkActions.classList.add('translate-y-full');
                setTimeout(() => {
                    bulkActions.classList.add('hidden');
                }, 300);
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('btnFilter').addEventListener('click', function() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                if (statusFilter === '') {
                    row.style.display = '';
                } else {
                    const statusCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                    row.style.display = statusCell.includes(statusFilter) ? '' : 'none';
                }
            });
        });

        // Reset functionality
        document.getElementById('btnReset').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.querySelectorAll('#tableBody tr').forEach(row => {
                row.style.display = '';
            });
        });

        // Delete buttons
        document.querySelectorAll('button[title="Hapus"]').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                    alert('Data berhasil dihapus!');
                }
            });
        });
    </script>
@endpush
