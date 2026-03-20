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
                            <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
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
                class="flex items-center px-4 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600">
                <i class="mr-2 fas fa-plus"></i> Tambah Kasir
            </a>
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Search -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i> Cari Kasir
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama, username atau nomor HP..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-filter"></i> Status
                </label>
                <select id="statusFilter"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ ($status ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ ($status ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="flex items-end justify-end space-x-2 md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-4 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                    <i class="mr-2 fas fa-redo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-user-tie"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Kasir</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">{{ $kasirs->total() }}</span> kasir</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">Nama
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Username</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">No HP
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase w-28">
                            Status</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @forelse ($kasirs as $index => $kasir)
                        <tr class="transition-colors hover:bg-gray-50" data-kasir-id="{{ $kasir->id }}"
                            data-status="{{ $kasir->status }}" data-nama="{{ strtolower($kasir->nama) }}"
                            data-username="{{ strtolower($kasir->username) }}" data-nohp="{{ $kasir->no_hp }}">
                            <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $kasirs->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $kasir->nama }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $kasir->username }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $kasir->no_hp }}</div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($kasir->status == 'aktif')
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full status-badge">
                                        <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full status-badge">
                                        <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.kasir.edit', $kasir->id) }}"
                                        class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" onclick="toggleKasirStatus({{ $kasir->id }})"
                                        class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                        title="Toggle Status">
                                        <i class="fas fa-toggle-on"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-users"></i>
                                <p>Belum ada data kasir</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- No Result Row (hidden by default) -->
            <div id="noResultRow" class="hidden py-12 text-center text-gray-500">
                <i class="mb-2 text-3xl fas fa-search"></i>
                <p>Tidak ada data yang cocok dengan filter</p>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="showingInfo"
                    class="font-semibold text-gray-900">{{ $kasirs->firstItem() }}-{{ $kasirs->lastItem() }}</span>
                dari <span class="font-semibold text-gray-900">{{ $kasirs->total() }}</span> kasir
            </div>
            <div class="flex items-center gap-2">
                {{ $kasirs->appends(['search' => request('search'), 'status' => request('status')])->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // SweetAlert session messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonColor: '#10b981',
                background: '#ffffff',
                color: '#1f2937',
                iconColor: '#A5DC86'
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#ef4444',
                background: '#ffffff',
                color: '#1f2937',
                iconColor: '#ef4444'
            });
        @endif

        let currentSearch = '';
        let currentStatus = '';

        // Live Search
        document.getElementById('searchInput').addEventListener('input', debounce(function(e) {
            currentSearch = e.target.value.toLowerCase().trim();
            applyFilters();
        }, 300));

        // Status Filter
        document.getElementById('statusFilter').addEventListener('change', function() {
            currentStatus = this.value;
            applyFilters();
        });

        // Reset
        document.getElementById('btnReset').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            currentSearch = '';
            currentStatus = '';
            applyFilters();
        });

        function applyFilters() {
            const rows = document.querySelectorAll('#tableBody tr[data-kasir-id]');
            let visibleCount = 0;

            rows.forEach(row => {
                const nama = row.dataset.nama || '';
                const username = row.dataset.username || '';
                const nohp = row.dataset.nohp || '';
                const status = row.dataset.status || '';

                // Search filter
                const matchSearch = !currentSearch ||
                    nama.includes(currentSearch) ||
                    username.includes(currentSearch) ||
                    nohp.includes(currentSearch);

                const matchStatus = !currentStatus || status === currentStatus;

                const show = matchSearch && matchStatus;
                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            const noResultRow = document.getElementById('noResultRow');
            if (noResultRow) {
                noResultRow.classList.toggle('hidden', visibleCount > 0);
            }

            document.getElementById('totalData').textContent = visibleCount;
        }

        // Toggle Status
        function toggleKasirStatus(kasirId) {
            const row = document.querySelector(`tr[data-kasir-id="${kasirId}"]`);
            const kasirName = row.dataset.nama;
            const curStatus = row.dataset.status;
            const newStatus = curStatus === 'aktif' ? 'Nonaktif' : 'Aktif';

            Swal.fire({
                title: 'Yakin?',
                text: `Ubah status "${kasirName}" menjadi ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: `Ya, ${newStatus.toLowerCase()}kan!`,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/kasir/${kasirId}/toggle-status`;
                }
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
    </script>
@endpush
