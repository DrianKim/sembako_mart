@extends('owner.layouts.app')
@section('title', 'Laporan Penjualan')
@section('page-description', 'Pantau omzet, transaksi, dan performa penjualan.')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Laporan Penjualan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Ringkasan Card -->
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Total Penjualan</h4>
            <p class="text-2xl font-bold text-green-600">Rp 1.827.500</p>
            <p class="mt-1 text-gray-500 text-s">Periode: 1 - 31 Maret 2026</p>
            <p class="mt-1 text-xs text-gray-400">*Total Penjualan Akan Diperbarui Setiap Bulan</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Jumlah Transaksi</h4>
            <p class="text-2xl font-bold text-green-600">142</p>
            <p class="mt-1 text-gray-500 text-s">Rata-rata Rp 12.870/transaksi</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Produk Terlaris</h4>
            <p class="text-2xl font-bold text-green-600">Beras Pandan 5kg</p>
            <p class="mt-1 text-gray-500 text-s">Terjual 85 kg</p>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-medium text-gray-600">Kasir Terbaik</h4>
            <p class="text-2xl font-bold text-green-600">Andi Susanto</p>
            <p class="mt-1 text-gray-500 text-s">Omzet Rp 845.000</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-5 md:gap-4">
            <!-- Periode -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-calendar-day"></i>
                    Periode
                </label>
                <select id="periodeFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan" selected>Bulanan</option>
                    <option value="custom">Custom Tanggal</option>
                </select>
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

            <!-- Kasir Filter -->
            <div class="md:col-span-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-user-tie"></i>
                    Kasir
                </label>
                <select id="kasirFilter"
                    class="w-full px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <option value="">Semua Kasir</option>
                    <option value="andi">Andi Susanto</option>
                    <option value="siti">Siti Rahayu</option>
                    <option value="budi">Budi Santoso</option>
                </select>
            </div>

            <!-- Reset - pojok kanan -->
            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm">
                    <i class="mr-2 fas fa-redo"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Grafik Omzet (pakai Chart.js, tinggi terkontrol) -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-800">Grafik Omzet Penjualan</h3>
        <!-- Container tinggi fixed & responsif -->
        <div class="relative w-full h-64 md:h-80 lg:h-96">
            <canvas id="omzetChart"></canvas>
        </div>
    </div>

    <!-- Table Detail Transaksi -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi</h3>
                    <p class="text-sm text-gray-600">Menampilkan 142 transaksi</p>
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

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">Tanggal
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
                    <!-- Dummy Row 1 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900">1</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-03-10 14:45:00</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Budi</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">TRX-20260310-045</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 185.000</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('owner.laporan_penjualan.struk', 45) }}" target="_blank"
                                class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                title="Cetak Struk">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Dummy Row 2 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900">2</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-03-10 15:30:22</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Siti Rahayu</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Ani</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">TRX-20260310-046</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 92.500</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('owner.laporan_penjualan.struk', 46) }}" target="_blank"
                                class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                title="Cetak Struk">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    <!-- Tambah dummy lain sesuai kebutuhan -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span class="font-semibold text-gray-900">1-2</span> dari
                <span class="font-semibold text-gray-900">142</span> transaksi
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
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dummy data
        const labels = ['1 Mar', '2 Mar', '3 Mar', '4 Mar', '5 Mar', '6 Mar', '7 Mar', '8 Mar', '9 Mar', '10 Mar'];
        const omzetData = [120000, 180000, 95000, 250000, 145000, 320000, 89000, 210000, 175000, 185000];

        const ctx = document.getElementById('omzetChart').getContext('2d');
        const omzetChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet Harian (Rp)',
                    data: omzetData,
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
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
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

        // Filter live (dummy simulasi update chart)
        function applyFilters() {
            const periode = document.getElementById('periodeFilter').value;
            if (periode === 'harian') {
                omzetChart.data.labels = ['1 Mar', '2 Mar', '3 Mar'];
                omzetChart.data.datasets[0].data = [120000, 180000, 95000];
            } else if (periode === 'mingguan') {
                omzetChart.data.labels = ['Minggu 1', 'Minggu 2', 'Minggu 3'];
                omzetChart.data.datasets[0].data = [850000, 1200000, 950000];
            } else {
                // bulanan default
                omzetChart.data.labels = labels;
                omzetChart.data.datasets[0].data = omzetData;
            }
            omzetChart.update();
        }

        // Event listeners
        document.getElementById('periodeFilter')?.addEventListener('change', applyFilters);
        document.getElementById('fromDate')?.addEventListener('change', applyFilters);
        document.getElementById('toDate')?.addEventListener('change', applyFilters);
        document.getElementById('kasirFilter')?.addEventListener('change', applyFilters);

        // Reset
        document.getElementById('btnReset')?.addEventListener('click', function() {
            document.getElementById('periodeFilter').value = 'bulanan';
            document.getElementById('fromDate').value = '';
            document.getElementById('toDate').value = '';
            document.getElementById('kasirFilter').value = '';
            applyFilters();
        });

        // Initial apply
        applyFilters();
    </script>
@endpush
