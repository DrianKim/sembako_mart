@extends('owner.layouts.app')
@section('title', 'Dashboard Owner')

@push('styles')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <!-- Header Dashboard -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 md:text-3xl">Dashboard Owner</h1>
        <p class="mt-1 text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}! Ini ringkasan bisnis Anda hari ini.
        </p>
    </div>

    <!-- Ringkasan Card -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Omzet Hari Ini -->
        <div class="p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Omzet Hari Ini</p>
                    <p class="mt-1 text-2xl font-bold text-green-600 md:text-3xl">Rp 4.250.000</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="text-2xl text-green-600 fas fa-wallet"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">+12% dari kemarin</p>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transaksi Hari Ini</p>
                    <p class="mt-1 text-2xl font-bold text-green-600 md:text-3xl">128</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="text-2xl text-blue-600 fas fa-receipt"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Rata-rata Rp 33.200/transaksi</p>
        </div>

        <!-- Omzet Bulan Ini -->
        <div class="p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Omzet Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold text-green-600 md:text-3xl">Rp 78.450.000</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="text-2xl text-purple-600 fas fa-chart-line"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">+18% dari bulan lalu</p>
        </div>

        <!-- Kasir Aktif -->
        <div class="p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Kasir Aktif</p>
                    <p class="mt-1 text-2xl font-bold text-green-600 md:text-3xl">4</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="text-2xl text-yellow-600 fas fa-users"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">Semua sedang online</p>
        </div>
    </div>

    <!-- Grafik Omzet Minggu Ini -->
    <div class="p-6 mt-8 bg-white border border-gray-200 shadow-sm rounded-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Omzet Minggu Ini</h3>
            <select id="periodeGrafik"
                class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                <option value="minggu">Minggu Ini</option>
                <option value="bulan">Bulan Ini</option>
            </select>
        </div>
        <div class="relative w-full h-64 md:h-80">
            <canvas id="omzetChart"></canvas>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="mt-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Transaksi Terbaru</h3>
            <a href="{{ route('owner.riwayat_transaksi') }}"
                class="flex items-center text-sm font-medium text-green-600 hover:text-green-700">
                Lihat Semua <i class="ml-1 fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-left text-gray-600 uppercase">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-left text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-left text-gray-600 uppercase">Kasir</th>
                        <th class="px-6 py-4 text-xs font-semibold text-left text-gray-600 uppercase">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-right text-gray-600 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Dummy 5 transaksi terbaru -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">TRX-20260315-089</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15 Mar 2026 14:45</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Budi</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 185.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">TRX-20260315-088</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15 Mar 2026 13:20</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Siti Rahayu</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Ani</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 320.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">TRX-20260315-087</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15 Mar 2026 11:55</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rina</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 450.000</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">TRX-20260315-086</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15 Mar 2026 10:30</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Siti Rahayu</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Doni</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 92.500</td>
                    </tr>

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">TRX-20260315-085</td>
                        <td class="px-6 py-4 text-sm text-gray-900">15 Mar 2026 09:15</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Andi Susanto</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Sari</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 275.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('owner.riwayat_transaksi') }}"
            class="flex items-center p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="p-4 mr-4 bg-green-100 rounded-full">
                <i class="text-2xl text-green-600 fas fa-receipt"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Riwayat Transaksi</h4>
                <p class="text-sm text-gray-600">Lihat semua transaksi</p>
            </div>
        </a>

        <a href="{{ route('owner.laporan_penjualan') }}"
            class="flex items-center p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="p-4 mr-4 bg-blue-100 rounded-full">
                <i class="text-2xl text-blue-600 fas fa-chart-line"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Laporan Penjualan</h4>
                <p class="text-sm text-gray-600">Detail omzet & performa</p>
            </div>
        </a>

        <a href="{{ route('owner.log') }}"
            class="flex items-center p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="p-4 mr-4 bg-purple-100 rounded-full">
                <i class="text-2xl text-purple-600 fas fa-history"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Log Aktivitas</h4>
                <p class="text-sm text-gray-600">Pantau admin & kasir</p>
            </div>
        </a>

        <a href="{{ route('owner.user') }}"
            class="flex items-center p-6 transition-shadow bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md">
            <div class="p-4 mr-4 bg-yellow-100 rounded-full">
                <i class="text-2xl text-yellow-600 fas fa-users"></i>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800">Manajemen Users</h4>
                <p class="text-sm text-gray-600">Tambah & kelola admin/kasir</p>
            </div>
        </a>
    </div>
@endsection

@push('scripts')
    <script>
        // Chart Omzet Minggu Ini
        const ctx = document.getElementById('omzetChart')?.getContext('2d');
        if (ctx) {
            const omzetChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Omzet Minggu Ini (Rp)',
                        data: [850000, 1200000, 950000, 1450000, 1100000, 1800000, 750000],
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
                                    return 'Rp ' + value.toLocaleString('id-ID', {
                                        notation: 'compact'
                                    });
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
        }

        // Filter periode simulasi (nanti real AJAX)
        document.getElementById('periodeFilter')?.addEventListener('change', function() {
            // Untuk real: reload data atau update chart
            console.log('Periode diubah ke:', this.value);
        });
    </script>
@endpush
