@extends('kasir.layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-description', 'Lihat riwayat transaksi yang sudah dilakukan.')

@section('content')
    <!-- Breadcrumb & Header -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('kasir.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="w-4 h-4 mr-2 fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Riwayat Transaksi</span>
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
            <div class="md:col-span-4">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Transaksi
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" value="{{ $search ?? '' }}"
                        placeholder="Cari nama pelanggan, nomor unik, atau tanggal..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Dari Tanggal -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i>
                    Dari Tanggal
                </label>
                <input type="date" id="fromDate" value="{{ $from_date ?? '' }}"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Sampai Tanggal -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i>
                    Sampai Tanggal
                </label>
                <input type="date" id="toDate" value="{{ $to_date ?? '' }}"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
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
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Riwayat -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalTransaksi"
                            class="font-semibold text-green-600">3</span> transaksi</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">No</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Pelanggan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Nomor Unik</th>
                        <th class="px-4 py-3 text-xs font-semibold text-right text-gray-600 uppercase">Total</th>
                        <th class="px-4 py-3 text-xs font-semibold text-center text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @include('kasir._riwayat_table')
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            class="flex flex-col items-center justify-between px-6 py-4 text-sm text-gray-600 border-t bg-gray-50 sm:flex-row">
            <div class="mb-4 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $transaksis->firstItem() ?? 0 }}-{{ $transaksis->lastItem() ?? 0 }}
                </span> dari
                <span id="totalTransaksi" class="font-semibold text-green-600">{{ $transaksis->total() }}</span> transaksi
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                @include('kasir._riwayat_pagination')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let searchTimer = null;
        let currentPerPage = {{ $per_page }};

        function loadData(page = 1) {
            currentPage = page;

            $.ajax({
                url: '{{ route('kasir.riwayat_transaksi') }}',
                method: 'GET',
                data: {
                    page: page,
                    search: $('#searchInput').val().trim(),
                    from_date: $('#fromDate').val(),
                    to_date: $('#toDate').val(),
                    per_page: currentPerPage
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="6" class="py-10 text-center text-gray-500">
                                <i class="mr-2 fas fa-spinner fa-spin"></i> Memuat data...
                            </td>
                        </tr>
                    `);
                },
                success: function(res) {
                    $('#tableBody').html(res.html);
                    $('#paginationContainer').html(res.pagination);
                    $('#totalTransaksi').text(res.total);
                    $('#pageInfo').text((res.from ?? 0) + '-' + (res.to ?? 0));
                    bindPagination();
                },
                error: function() {
                    $('#tableBody').html(`
                        <tr>
                            <td colspan="6" class="py-10 text-center text-red-500">
                                Gagal memuat data.
                            </td>
                        </tr>
                    `);
                }
            });
        }

        function bindPagination() {
            $(document).off('click', '.pagination-link').on('click', '.pagination-link', function(e) {
                e.preventDefault();
                loadData($(this).data('page'));
            });
        }

        // Search debounce
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => loadData(1), 400);
        });

        // Date change
        $('#fromDate').on('change', function() {
            const fromVal = $(this).val();
            $('#toDate').attr('min', fromVal || '');
            if ($('#toDate').val() && $('#toDate').val() < fromVal) {
                $('#toDate').val(fromVal);
            }
            loadData(1);
        });

        $('#toDate').on('change', function() {
            $('#fromDate').attr('max', $(this).val() || '');
            loadData(1);
        });

        // Per Page Change
        $('#perPage').on('change', function() {
            currentPerPage = parseInt($(this).val());
            loadData(1);
        });

        // Reset
        $('#btnReset').on('click', function() {
            $('#searchInput').val('');
            $('#fromDate').val('').removeAttr('max');
            $('#toDate').val('').removeAttr('min');
            $('#perPage').val(10);
            currentPerPage = 10;
            loadData(1);
        });

        // Init
        $(document).ready(function() {
            bindPagination();
            loadData(1);
        });
    </script>
@endpush
