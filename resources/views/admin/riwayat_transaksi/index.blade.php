@extends('admin.layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-description', 'Halaman untuk melihat dan mengelola riwayat transaksi.')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Riwayat Transaksi</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Transaksi
                </label>
                <div class="relative">
                    <input type="text" id="searchInput"
                        placeholder="Cari nama pelanggan, nomor unik, kasir, atau tanggal..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Dari Tanggal -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i>
                    Dari Tanggal
                </label>
                <input type="date" id="fromDate"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Sampai Tanggal -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i>
                    Sampai Tanggal
                </label>
                <input type="date" id="toDate"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <!-- Reset - satu jajar nempel di kanan (kolom ke-5) -->
            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm">
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
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
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Kasir</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Pelanggan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-left text-gray-600 uppercase">Nomor Unik</th>
                        <th class="px-4 py-3 text-xs font-semibold text-right text-gray-600 uppercase">Total</th>
                        <th class="px-4 py-3 text-xs font-semibold text-center text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @include('admin.riwayat_transaksi._table')
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
                @include('admin.riwayat_transaksi._pagination')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let searchTimer = null;

        function getFilters() {
            return {
                page: currentPage,
                search: $('#searchInput').val(),
                from_date: $('#fromDate').val(),
                to_date: $('#toDate').val(),
            };
        }

        function loadData(page = 1) {
            currentPage = page;

            $.ajax({
                url: '{{ route('admin.riwayat_transaksi') }}',
                method: 'GET',
                data: getFilters(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-500">
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
                        <td colspan="7" class="py-10 text-center text-red-500">
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

        // Validasi range tanggal
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

        // Reset
        $('#btnReset').on('click', function() {
            $('#searchInput').val('');
            $('#fromDate').val('').removeAttr('max');
            $('#toDate').val('').removeAttr('min');
            loadData(1);
        });

        // SweetAlert session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
            });
        @endif

        // Init
        bindPagination();
    </script>
@endpush
