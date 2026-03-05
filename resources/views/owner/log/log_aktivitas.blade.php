@extends('owner.layouts.app')
@section('title', 'Log Aktivitas')
@section('page-description', 'Riwayat aktivitas Admin dan Kasir di sistem.')

@section('content')
    <!-- Breadcrumb & Header -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Log Aktivitas</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Search - span 3 biar full width dominan & mentok -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Aktivitas
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan user atau deskripsi aktivitas..."
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Role -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-user-shield"></i>
                    Role
                </label>
                <select id="roleFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                </select>
            </div>

            <!-- Reset - pojok kanan banget, nempel di ujung grid -->
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
                    <i class="text-xl text-green-600 fas fa-history"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Aktivitas Admin & Kasir</h3>
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
                            User
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
                    <!-- Dummy Row 1 - Admin -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="admin">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Admin Sembako Mart (Admin)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Melakukan login ke sistem</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 08:03:32</td>
                    </tr>

                    <!-- Dummy Row 2 - Kasir -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="kasir">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto (Kasir)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Memproses transaksi TRX-20260220-001 (Rp 185.000)</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 09:45:12</td>
                    </tr>

                    <!-- Dummy Row 3 - Admin -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="admin">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Admin Sembako Mart (Admin)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Menambahkan kasir baru: Siti Rahayu</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 11:45:03</td>
                    </tr>

                    <!-- Dummy Row 4 - Kasir -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="kasir">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">4</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Budi Santoso (Kasir)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Melakukan refund transaksi TRX-20260219-002</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 13:10:55</td>
                    </tr>

                    <!-- Dummy Row 5 - Admin -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="admin">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">5</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Admin Sembako Mart (Admin)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Mengubah status kasir Budi Santoso menjadi Nonaktif</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 14:30:22</td>
                    </tr>

                    <!-- Dummy Row 6 - Kasir -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="kasir">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">6</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Siti Rahayu (Kasir)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Memproses transaksi TRX-20260221-004 (Rp 320.000)</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-21 09:15:47</td>
                    </tr>

                    <!-- Dummy Row 7 - Admin -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="admin">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">7</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Admin Sembako Mart (Admin)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Menambahkan stok produk Minyak Goreng +200 liter</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-21 11:12:41</td>
                    </tr>

                    <!-- Dummy Row 8 - Kasir -->
                    <tr class="transition-colors hover:bg-gray-50" data-role="kasir">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">8</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto (Kasir)</td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Melakukan logout dari sistem setelah shift selesai</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-21 18:30:12</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer with Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-8</span> dari
                <span id="totalData" class="font-semibold text-gray-900">8</span> aktivitas
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
        // Fungsi filter (search + role)
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const roleVal = document.getElementById('roleFilter').value.toLowerCase();

            let visibleCount = 0;

            document.querySelectorAll('#tableBody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowRole = row.getAttribute('data-role') || '';

                const matchSearch = text.includes(searchTerm);
                const matchRole = roleVal === '' || rowRole === roleVal;

                const show = matchSearch && matchRole;
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('totalData').textContent = visibleCount;
        }

        // Event listeners
        document.getElementById('searchInput')?.addEventListener('input', applyFilters);
        document.getElementById('roleFilter')?.addEventListener('change', applyFilters);

        // Reset
        document.getElementById('btnReset')?.addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('roleFilter').value = '';
            applyFilters();
        });

        // Initial apply
        applyFilters();
    </script>
@endpush
