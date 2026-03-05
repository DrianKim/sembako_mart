@extends('owner.layouts.app')
@section('title', 'Daftar User')
@section('page-description', 'Lihat dan kelola semua data user (Admin & Kasir).')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Daftar User</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Button Tambah User -->
            <a href="{{ route('owner.user.create') }}"
                class="flex items-center px-5 py-2.5 text-white transition-all duration-200 bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="mr-2 fas fa-plus"></i>
                Tambah User
            </a>
        </div>
    </section>

    <!-- Filter & Search - FULL MENTOK, satu baris di desktop -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Search - span 2 biar lebar -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari User
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama, username atau nomor HP..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="md:col-span-1">
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

            <!-- Role Filter -->
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

            <!-- Button Reset - satu jajar, rata kanan di desktop -->
            <div class="flex items-end justify-start md:col-span-1 md:justify-end">
                <button id="btnReset"
                    class="flex items-center justify-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm min-w-[140px]">
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Table Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-users-cog"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar User</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalTransaksi"
                            class="font-semibold text-green-600">7</span> user</p>
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
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">NO
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">NAMA
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">ROLE
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            USERNAME</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">NO HP
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            STATUS</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">AKSI
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    <!-- Dummy Row 1 - Admin -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Admin</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                Admin
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">admin_1</td>
                        <td class="px-6 py-4 text-sm text-gray-900">08192837465</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('owner.user.edit', 1) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 2 - Kasir Aktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Kasir 1</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                Kasir
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">Kasir_1_1</td>
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
                                <a href="{{ route('owner.user.edit', 2) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 3 - Kasir Aktif (contoh warna oranye untuk Kasir) -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Aduy Neste</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                Kasir
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">aduy_kasir</td>
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
                                <a href="{{ route('owner.user.edit', 3) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 4 - Kasir Nonaktif -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">4</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Budi Santoso</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                Kasir
                            </span>
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
                                <a href="{{ route('owner.user.edit', 4) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Tambah dummy lain sesuai kebutuhan (total 7) -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-4</span> dari <span id="totalShown"
                    class="font-semibold text-gray-900">7</span> data
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
        // Fungsi filter (search + status + role)
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const statusVal = document.getElementById('statusFilter').value.toLowerCase();
            const roleVal = document.getElementById('roleFilter').value.toLowerCase();

            let visibleCount = 0;

            document.querySelectorAll('#tableBody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                const statusBadge = row.querySelector('td:nth-child(6) span')?.textContent.toLowerCase().trim() ||
                    '';
                const roleBadge = row.querySelector('td:nth-child(3) span')?.textContent.toLowerCase().trim() || '';

                const matchSearch = text.includes(searchTerm);
                const matchStatus = statusVal === '' || statusBadge.includes(statusVal);
                const matchRole = roleVal === '' || roleBadge.includes(roleVal);

                const show = matchSearch && matchStatus && matchRole;
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            document.getElementById('totalData').textContent = visibleCount;
            document.getElementById('totalShown').textContent = visibleCount;
        }

        // Event listeners
        document.getElementById('searchInput')?.addEventListener('input', applyFilters);
        document.getElementById('statusFilter')?.addEventListener('change', applyFilters);
        document.getElementById('roleFilter')?.addEventListener('change', applyFilters);

        // Tombol Terapkan & Reset
        document.getElementById('btnFilter')?.addEventListener('click', applyFilters);
        document.getElementById('btnReset')?.addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('roleFilter').value = '';
            applyFilters();
        });

        // Initial apply
        applyFilters();
    </script>
@endpush
