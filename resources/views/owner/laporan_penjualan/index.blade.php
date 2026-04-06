@extends('owner.layouts.app')
@section('title', 'Laporan Penjualan')
@section('page-description', 'Pantau omzet, transaksi, dan performa penjualan.')

@section('content')
    <!-- Breadcrumb -->
    <section class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('owner.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                        <i class="w-4 h-4 mr-2 fas fa-home"></i>Dashboard
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Laporan Penjualan</span>
                    </div>
                </li>
            </ol>
        </nav>
    </section>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Total Penjualan</h4>
            <p class="text-2xl font-bold text-green-600" id="cardTotalPenjualan">
                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </p>
            <p class="mt-1 text-sm text-gray-500" id="cardPeriodeLabel">
                Periode: {{ now()->startOfMonth()->format('d M Y') }} - {{ now()->endOfMonth()->format('d M Y') }}
            </p>
            <p class="mt-1 text-xs text-gray-400">*Diperbarui sesuai filter aktif</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Jumlah Transaksi</h4>
            <p class="text-2xl font-bold text-green-600" id="cardJumlahTransaksi">{{ $jumlahTransaksi }}</p>
            <p class="mt-1 text-sm text-gray-500">Rata-rata Rp <span
                    id="cardRataRata">{{ number_format($rataRata, 0, ',', '.') }}</span>/transaksi</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Produk Terlaris</h4>
            <p class="text-xl font-bold text-green-600 truncate" id="cardProdukTerlaris">
                {{ $produkTerlaris?->produk?->nama_produk ?? '-' }}
            </p>
            <p class="mt-1 text-sm text-gray-500">Terjual <span
                    id="cardProdukQty">{{ $produkTerlaris?->total_qty ?? 0 }}</span></p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Kasir Terbaik</h4>
            <p class="text-xl font-bold text-green-600 truncate" id="cardKasirTerbaik">
                {{ $kasirTerbaik?->kasir?->nama ?? '-' }}
            </p>
            <p class="mt-1 text-sm text-gray-500">Omzet Rp <span
                    id="cardKasirOmzet">{{ number_format($kasirTerbaik?->total_omzet ?? 0, 0, ',', '.') }}</span></p>
        </div>
    </div>

    <!-- Filter -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-day"></i> Periode
                </label>
                <select id="periodeFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="harian" {{ $periodeFilter === 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="mingguan" {{ $periodeFilter === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulanan" {{ $periodeFilter === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="custom" {{ $periodeFilter === 'custom' ? 'selected' : '' }}>Custom Tanggal</option>
                </select>
            </div>

            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i> Dari Tanggal
                </label>
                <input type="date" id="fromDate" value="{{ $fromDate ?? '' }}"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-alt"></i> Sampai Tanggal
                </label>
                <input type="date" id="toDate" value="{{ $toDate ?? '' }}"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>

            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-user-tie"></i> Kasir
                </label>
                <select id="kasirFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Kasir</option>
                    @foreach ($kasirs as $kasir)
                        <option value="{{ $kasir->id }}" {{ $kasirId == $kasir->id ? 'selected' : '' }}>
                            {{ $kasir->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm">
                    <i class="mr-2 fas fa-redo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">Grafik Omzet Penjualan</h3>
        <div class="relative w-full h-64 md:h-80 lg:h-96">
            <canvas id="omzetChart"></canvas>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi</h3>
                    <p class="text-sm text-gray-600">Menampilkan <span
                            id="totalTransaksiLabel">{{ $transaksis->total() }}</span> transaksi</p>
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
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Tanggal
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">Kasir
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">Nomor
                            Unik</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-right text-gray-600 uppercase">Total
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @include('owner.laporan_penjualan._table')
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $transaksis->firstItem() ?? 0 }}-{{ $transaksis->lastItem() ?? 0 }}
                </span> dari
                <span class="font-semibold text-gray-900" id="totalRows">{{ $transaksis->total() }}</span> transaksi
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                @include('owner.laporan_penjualan._pagination')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Init Chart
        const ctx = document.getElementById('omzetChart').getContext('2d');
        let omzetChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($grafikLabels) !!},
                datasets: [{
                    label: 'Omzet Harian (Rp)',
                    data: {!! json_encode($grafikOmzet) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 8,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: v => 'Rp ' + v.toLocaleString('id-ID')
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // State
        let currentPage = 1;
        let filterTimer = null;

        function getFilters() {
            return {
                periode: $('#periodeFilter').val(),
                from_date: $('#fromDate').val(),
                to_date: $('#toDate').val(),
                kasir_id: $('#kasirFilter').val(),
                page: currentPage,
            };
        }

        function loadData(page = 1) {
            currentPage = page;

            $.ajax({
                url: '{{ route('owner.laporan_penjualan') }}',
                method: 'GET',
                data: getFilters(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                beforeSend: function() {
                    $('#tableBody').html(`
                    <tr><td colspan="7" class="py-12 text-center text-gray-500">
                        <i class="mr-2 fas fa-spinner fa-spin"></i> Memuat data...
                    </td></tr>
                `);
                },
                success: function(res) {
                    // Update tabel
                    $('#tableBody').html(res.html);
                    $('#paginationContainer').html(res.pagination);
                    $('#totalTransaksiLabel').text(res.total);
                    $('#totalRows').text(res.total);
                    if (res.from && res.to) $('#pageInfo').text(res.from + '-' + res.to);

                    // Update cards
                    $('#cardTotalPenjualan').text('Rp ' + res.totalPenjualan);
                    $('#cardJumlahTransaksi').text(res.jumlahTransaksi);
                    $('#cardRataRata').text(res.rataRata);
                    $('#cardProdukTerlaris').text(res.produkTerlaris);
                    $('#cardProdukQty').text(res.produkQty);
                    $('#cardKasirTerbaik').text(res.kasirTerbaik);
                    $('#cardKasirOmzet').text(res.kasirOmzet);
                    $('#cardPeriodeLabel').text('Periode: ' + res.periodeLabel);

                    // Update chart
                    omzetChart.data.labels = res.grafikLabels;
                    omzetChart.data.datasets[0].data = res.grafikOmzet;
                    omzetChart.update();

                    bindPagination();
                },
                error: function() {
                    $('#tableBody').html(`
                    <tr><td colspan="7" class="py-12 text-center text-red-500">
                        <i class="mr-2 fas fa-exclamation-triangle"></i> Gagal memuat data.
                    </td></tr>
                `);
                }
            });
        }

        function bindPagination() {
            $(document).off('click', '.pagination-link')
                .on('click', '.pagination-link', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    if (page) loadData(page);
                });
        }

        // Date validation helpers
        function validateDates() {
            const fromVal = $('#fromDate').val();
            const toVal = $('#toDate').val();

            // Set min/max constraints
            if (fromVal) {
                $('#toDate').attr('min', fromVal);
            } else {
                $('#toDate').removeAttr('min');
            }

            if (toVal) {
                $('#fromDate').attr('max', toVal);
            } else {
                $('#fromDate').removeAttr('max');
            }

            // Cek kalau keduanya diisi tapi invalid
            if (fromVal && toVal && fromVal > toVal) {
                $('#fromDate').addClass('border-red-400 focus:ring-red-400');
                $('#toDate').addClass('border-red-400 focus:ring-red-400');
                showDateError('Tanggal "Dari" tidak boleh lebih besar dari "Sampai".');
                return false;
            }

            // Clear error state
            $('#fromDate, #toDate').removeClass('border-red-400 focus:ring-red-400');
            $('#dateErrorMsg').remove();
            return true;
        }

        function showDateError(msg) {
            if ($('#dateErrorMsg').length) return; // jangan duplikat
            const el =
                `<p id="dateErrorMsg" class="mt-2 text-xs text-red-500"><i class="mr-1 fas fa-exclamation-circle"></i>${msg}</p>`;
            $('#toDate').closest('.md\\:col-span-1').append(el);
        }

        // Filter listeners
        $('#periodeFilter, #kasirFilter').on('change', function() {
            clearTimeout(filterTimer);
            filterTimer = setTimeout(() => loadData(1), 400);
        });

        $('#fromDate').on('change', function() {
            clearTimeout(filterTimer);
            if (!validateDates()) return; // stop kalau invalid
            filterTimer = setTimeout(() => loadData(1), 400);
        });

        $('#toDate').on('change', function() {
            clearTimeout(filterTimer);
            if (!validateDates()) return; // stop kalau invalid
            filterTimer = setTimeout(() => loadData(1), 400);
        });

        // Reset
        $('#btnReset').on('click', function() {
            $('#periodeFilter').val('bulanan');
            $('#fromDate').val('').removeAttr('max');
            $('#toDate').val('').removeAttr('min');
            $('#fromDate, #toDate').removeClass('border-red-400 focus:ring-red-400');
            $('#dateErrorMsg').remove();
            loadData(1);
        });

        $(document).ready(function() {
            bindPagination();
        });
    </script>
@endpush
