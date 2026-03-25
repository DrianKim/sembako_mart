@extends('admin.layouts.app')
@section('title', 'Kategori Produk')
@section('page-description', 'Halaman untuk mengelola kategori produk.')

@section('content')
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Kategori Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <a href="{{ route('admin.kategori.create') }}"
                class="flex items-center px-4 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </section>

    <!-- Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:gap-4">
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Kategori
                </label>
                <div class="relative">
                    <form id="searchForm" method="GET" action="{{ route('admin.kategori') }}">
                        <input type="text" name="search" id="searchInput" value="{{ $search }}"
                            placeholder="Cari nama kategori..."
                            class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset" type="button"
                    class="flex items-center px-6 py-2.5 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm transition-all duration-200">
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Kategori</h3>
                    <p class="text-sm text-gray-600">
                        Total: <span id="totalData" class="font-semibold text-green-600">{{ $kategoris->total() }}</span>
                        kategori
                    </p>
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
                            Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @include('admin.kategori._table')
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $kategoris->firstItem() ?? 0 }}-{{ $kategoris->lastItem() ?? 0 }}
                </span> dari
                <span id="totalData" class="font-semibold text-gray-900">{{ $kategoris->total() }}</span> kategori
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                @include('admin.kategori._pagination')
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
                url: '{{ route('admin.kategori') }}',
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
                        <td colspan="3" class="py-12 text-center text-gray-500">
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
                        <td colspan="3" class="py-12 text-center text-red-500">
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
                if (page) loadData(page, currentSearch);
            });
        }

        function bindDeleteForms() {
            $(document).off('submit', '.delete-form').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Yakin hapus kategori?',
                    text: "Data kategori akan dihapus permanen!",
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
            searchTimer = setTimeout(() => {
                loadData(1, term);
            }, 400);
        });

        // Reset Button
        $('#btnReset').on('click', function() {
            $('#searchInput').val('');
            loadData(1, '');
        });

        // Initial Load
        $(document).ready(function() {
            loadData(1, '');

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
