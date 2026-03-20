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

            {{-- <a href="{{ route('admin.stok.create') }}"
                class="flex items-center px-4 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                <i class="mr-2 fas fa-plus"></i>
                Tambah Stok
            </a> --}}
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Search -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i> Cari Produk
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama produk atau barcode..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Stok Filter Dropdown -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-filter"></i> Status Stok
                </label>
                <select id="stokFilter"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Stok</option>
                    <option value="aman" {{ $stok_filter == 'aman' ? 'selected' : '' }}>Stok Aman (>15)</option>
                    <option value="peringatan" {{ $stok_filter == 'peringatan' ? 'selected' : '' }}>Peringatan (6-15)
                    </option>
                    <option value="kritis" {{ $stok_filter == 'kritis' ? 'selected' : '' }}>Kritis (≤5)</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end justify-end space-x-2 md:col-span-1">
                {{-- <button id="btnFilter"
                    class="flex items-center px-4 py-2.5 text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all">
                    <i class="mr-1 fas fa-filter"></i> Filter
                </button> --}}
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
                    <i class="text-xl text-green-600 fas fa-boxes"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Stok Produk</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">{{ $produks->total() }}</span> produk</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase">No</th>
                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Gambar</th>
                        <th class="px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Nama Produk</th>
                        <th class="w-32 px-6 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Stok Saat Ini
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-center text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @forelse ($produks as $index => $produk)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $produks->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($produk->foto)
                                    <img src="https://yexkxhepiviphofpsymz.supabase.co/storage/v1/object/public/{{ $produk->foto }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="object-cover w-10 h-10 bg-gray-100 rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-lg">
                                        <i class="text-sm text-gray-500 fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $produk->nama_produk }}</div>
                                <div class="text-xs text-gray-500">Barcode: {{ $produk->barcode ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($produk->stok > 15)
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                        {{ number_format($produk->stok) }}
                                    </span>
                                @elseif($produk->stok > 5)
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                        {{ number_format($produk->stok) }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                        {{ number_format($produk->stok) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <!-- Tambah Stok -->
                                    <a href="{{ route('admin.stok.create', $produk->id) }}"
                                        class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                        title="Tambah Stok">
                                        <i class="fas fa-plus"></i>
                                    </a>

                                    <!-- Edit Produk -->
                                    <a href="{{ route('admin.stok.edit', $produk->id) }}"
                                        class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Edit Produk">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-boxes"></i>
                                <p>Belum ada data stok produk</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $produks->firstItem() }}-{{ $produks->lastItem() }}
                </span> dari
                <span id="totalData" class="font-semibold text-gray-900">{{ $produks->total() }}</span>
                produk
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                {{-- Previous --}}
                @if ($produks->onFirstPage())
                    <button
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                @else
                    <a href="{{ $produks->previousPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                        onclick="updatePageInfo()">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                    @if ($page == $produks->currentPage())
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">
                            {{ $page }}
                        </a>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                            onclick="updatePageInfo()">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($produks->hasMorePages())
                    <a href="{{ $produks->nextPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
                        onclick="updatePageInfo()">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Filter variables
        let currentSearch = '{{ $search ?? '' }}';
        let currentStokFilter = '{{ $stok_filter ?? '' }}';

        // Live Search - client-side INSTANT
        document.getElementById('searchInput').addEventListener('input', debounce(function(e) {
            currentSearch = e.target.value;
            applyFilters();
        }, 300));

        // Stok Filter - client-side INSTANT
        document.getElementById('stokFilter').addEventListener('change', function() {
            currentStokFilter = this.value;
            applyFilters();
        });

        // Server-side Filter (Ctrl+Enter atau double-click)
        document.getElementById('stokFilter').addEventListener('dblclick', function() {
            window.location.href =
                `{{ route('admin.stok') }}?search=${encodeURIComponent(currentSearch)}&stok_filter=${currentStokFilter}`;
        });

        // Reset - clear semua filters
        document.getElementById('btnReset').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('stokFilter').value = '';
            currentSearch = '';
            currentStokFilter = '';
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const noDataCell = row.querySelector('td[colspan]');
                if (!noDataCell) {
                    row.style.display = '';
                    visibleCount++;
                }
            });
            document.getElementById('totalData').textContent = visibleCount || '{{ $produks->total() }}';
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Apply client-side filters (INSTANT preview)
        function applyFilters() {
            const term = currentSearch.toLowerCase().trim();
            const stokFilter = currentStokFilter;
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const noDataCell = row.querySelector('td[colspan]');
                if (noDataCell) return;

                const text = row.textContent.toLowerCase();
                const stokCell = row.cells[3]; // Stok column (index 3)
                const stokText = stokCell.textContent.trim();
                const stokNum = parseInt(stokText.replace(/\D/g, '')) || 0;

                let showRow = true;

                // Search filter
                if (term && !text.includes(term)) {
                    showRow = false;
                }

                // Stok filter
                if (stokFilter) {
                    if (stokFilter === 'aman' && stokNum <= 15) showRow = false;
                    if (stokFilter === 'peringatan' && (stokNum <= 5 || stokNum > 15)) showRow = false;
                    if (stokFilter === 'kritis' && stokNum > 5) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
                if (showRow) visibleCount++;
            });

            document.getElementById('totalData').textContent = visibleCount || '{{ $produks->total() }}';
        }

        function updatePageInfo() {
            setTimeout(() => {
                const pageInfo = document.getElementById('pageInfo');
                const totalData = document.getElementById('totalData');
                if (pageInfo && totalData) {
                    // Update akan terjadi otomatis setelah page load
                }
            }, 100);
        }

        // SweetAlert messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
                iconColor: '#A5DC86'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
                iconColor: '#ef4444'
            });
        @endif
    </script>
@endpush
