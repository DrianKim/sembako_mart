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
                            <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
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
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-12 md:gap-4">

            <!-- Search -->
            <div class="md:col-span-5">
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

            <!-- Status Stok -->
            <div class="md:col-span-3">
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

            <!-- Per Page -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Tampilkan
                </label>
                <select id="perPage"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="10" {{ $per_page == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $per_page == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $per_page == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $per_page == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <!-- Reset -->
            <div class="flex items-end md:col-span-2">
                <button id="btnReset"
                    class="w-full flex items-center justify-center px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
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
                    <p class="text-sm text-gray-600">
                        Total: <span id="totalData" class="font-semibold text-green-600">{{ $produks->total() }}</span>
                        produk
                    </p>
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
                    @include('admin.stok._table')
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $produks->firstItem() ?? 0 }}-{{ $produks->lastItem() ?? 0 }}
                </span> dari
                <span id="totalData" class="font-semibold text-gray-900">{{ $produks->total() }}</span> produk
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                @include('admin.stok._pagination')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let currentSearch = '{{ $search ?? '' }}';
        let currentStokFilter = '{{ $stok_filter ?? '' }}';
        let currentPerPage = {{ $per_page }};
        let searchTimer = null;

        function loadData(page = 1, search = '', stokFilter = '', perPage = currentPerPage) {
            currentPage = page;
            currentSearch = search;
            currentStokFilter = stokFilter;
            currentPerPage = perPage;

            $.ajax({
                url: '{{ route('admin.stok') }}',
                method: 'GET',
                data: {
                    page: page,
                    search: search,
                    stok_filter: stokFilter,
                    per_page: perPage
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <i class="mr-2 fas fa-spinner fa-spin"></i> Memuat data...
                            </td>
                        </tr>
                    `);
                },
                success: function(res) {
                    $('#tableBody').html(res.html);
                    $('#paginationContainer').html(res.pagination);
                    $('#totalData').text(res.total);

                    if (res.from && res.to) {
                        $('#pageInfo').text(res.from + '-' + res.to);
                    }

                    bindPagination();
                },
                error: function() {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="5" class="py-12 text-center text-red-500">
                                Gagal memuat data. Silakan coba lagi.
                            </td>
                        </tr>
                    `);
                }
            });
        }

        function bindPagination() {
            $(document).off('click', '.pagination-link').on('click', '.pagination-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    loadData(page, currentSearch, currentStokFilter, currentPerPage);
                }
            });
        }

        // Search dengan debounce
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            const term = $(this).val().trim();
            searchTimer = setTimeout(() => {
                loadData(1, term, currentStokFilter, currentPerPage);
            }, 400);
        });

        // Stok Filter Change
        $('#stokFilter').on('change', function() {
            loadData(1, currentSearch, $(this).val(), currentPerPage);
        });

        // Per Page Change
        $('#perPage').on('change', function() {
            const newPerPage = parseInt($(this).val());
            loadData(1, currentSearch, currentStokFilter, newPerPage);
        });

        // Reset Button
        $('#btnReset').on('click', function() {
            $('#searchInput').val('');
            $('#stokFilter').val('');
            $('#perPage').val(10);
            loadData(1, '', '', 10);
        });

        // Initial Load
        $(document).ready(function() {
            loadData(1, currentSearch, currentStokFilter, currentPerPage);

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#10b981'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ef4444'
                });
            @endif
        });
    </script>
@endpush
