@extends('admin.layouts.app')
@section('title', 'Produk')
@section('page-description', 'Halaman untuk mengelola produk.')

@section('content')
    <!-- Breadcrumb -->
    <section class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Produk</span>
                    </div>
                </li>
            </ol>
        </nav>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:gap-4">
            <!-- Search -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Produk
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama produk, barcode, atau kategori..."
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Reset -->
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
        <!-- Table Header with Info + Button -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">{{ $produks->total() }}</span> produk</p>
                </div>
            </div>

            <!-- Button Tambah Produk -->
            <a href="{{ route('admin.produk.create') }}"
                class="flex items-center px-5 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
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
                            Harga Beli
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Harga Jual
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Satuan
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @include('admin.produk._table')
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $produks->firstItem() }}-{{ $produks->lastItem() }}
                </span> dari
                <span id="totalData" class="font-semibold text-gray-900">{{ $produks->total() }}</span>
                produk
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                {{-- Custom Pagination Buttons --}}
                @include('admin.produk._pagination')
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let currentSearch = '';
        let searchTimer = null;

        function loadData(page = 1, search = '') {
            currentPage = page;
            currentSearch = search;

            $.ajax({
                url: '{{ route('admin.produk') }}',
                method: 'GET',
                data: {
                    page,
                    search
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-500">
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

                    bindDeleteForms();
                    bindPagination();
                },
                error: function() {
                    $('#tableBody').html(`
                    <tr>
                        <td colspan="8" class="py-12 text-center text-red-500">
                            <i class="mr-2 fas fa-exclamation-triangle"></i>
                            Gagal memuat data. Silakan refresh halaman.
                        </td>
                    </tr>
                `);
                }
            });
        }

        function bindPagination() {
            $(document).off('click', '.pagination-link')
                .on('click', '.pagination-link', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    if (page) loadData(page, currentSearch);
                });
        }

        function bindDeleteForms() {
            $(document).off('submit', '.delete-form')
                .on('submit', '.delete-form', function(e) {
                    e.preventDefault();
                    const form = this;

                    Swal.fire({
                        title: 'Yakin hapus produk?',
                        text: "Data akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
        }

        // Search dengan debounce
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            const term = $(this).val().trim();
            searchTimer = setTimeout(() => loadData(1, term), 400);
        });

        // Reset
        $('#btnReset').on('click', function() {
            $('#searchInput').val('');
            loadData(1, '');
        });

        // Initial Load
        $(document).ready(function() {
            loadData(1, '');

            // SweetAlert Session
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
