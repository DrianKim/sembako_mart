@extends('owner.layouts.app')
@section('title', 'Dashboard Owner')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800 md:text-3xl">Dashboard Owner</h1>
            <p class="mt-1 text-sm text-gray-500">
                Selamat datang, {{ Auth::user()->nama }}! •
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Omzet Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Omzet Hari Ini</p>
                        <p class="mt-1 text-2xl font-bold text-green-600">
                            Rp {{ number_format($omzetHariIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-wallet text-2xl text-green-600"></i>
                    </div>
                </div>
                {{-- <p class="mt-3 text-xs {{ $persenHariIni >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $persenHariIni >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($persenHariIni) }}% dari kemarin
                </p> --}}
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Transaksi Hari Ini</p>
                        <p class="mt-1 text-2xl font-bold text-blue-600">{{ $transaksiHariIni }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-receipt text-2xl text-blue-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-blue-600">
                    Rata-rata Rp {{ number_format($rataRata, 0, ',', '.') }}/transaksi
                </p>
            </div>

            <!-- Omzet Bulan Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Omzet Bulan Ini</p>
                        <p class="mt-1 text-2xl font-bold text-purple-600">
                            Rp {{ number_format($omzetBulanIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-chart-line text-2xl text-purple-600"></i>
                    </div>
                </div>
                {{-- <p class="mt-3 text-xs {{ $persenBulan >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $persenBulan >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($persenBulan) }}% dari bulan lalu
                </p> --}}
            </div>

            <!-- Kasir Aktif -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kasir Aktif</p>
                        <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $kasirAktif }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <i class="fas fa-users text-2xl text-yellow-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-xs text-yellow-600">Kasir terdaftar & aktif</p>
            </div>
        </div>

        <!-- Chart + Top Kasir -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Chart (2/3) -->
            <div class="lg:col-span-2 p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">📈 Grafik Omzet</h3>
                    <select id="periodeGrafik"
                        class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="minggu">7 Hari Terakhir</option>
                        <option value="bulan">Bulan Ini</option>
                    </select>
                </div>
                <div class="relative h-64 md:h-72">
                    <canvas id="omzetChart"></canvas>
                </div>
            </div>

            <!-- Top Kasir (1/3) -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🏆 Top Kasir Hari Ini</h3>
                <div class="space-y-3">
                    @forelse($topKasir as $i => $k)
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                        {{ $i === 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $k->kasir->nama ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $k->jumlah_transaksi }} transaksi</p>
                            </div>
                            <p class="text-sm font-semibold text-green-600 whitespace-nowrap">
                                Rp {{ number_format($k->total_omzet, 0, ',', '.') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Belum ada transaksi hari ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">🧾 Transaksi Terbaru</h3>
                <a href="{{ route('owner.riwayat_transaksi') }}"
                    class="text-sm font-medium text-green-600 hover:underline">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No. Transaksi</th>
                            <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                            <th class="px-6 py-3 text-left font-semibold">Kasir</th>
                            <th class="px-6 py-3 text-left font-semibold">Pelanggan</th>
                            <th class="px-6 py-3 text-right font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transaksiTerbaru as $trx)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $trx->nomor_unik }}</td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-3 text-gray-700">{{ $trx->kasir->nama ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $trx->nama_pelanggan }}</td>
                                <td class="px-6 py-3 text-right font-semibold text-gray-900">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('owner.riwayat_transaksi') }}"
                class="flex items-center gap-4 p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-receipt text-xl text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Riwayat Transaksi</h4>
                    <p class="text-sm text-gray-500">Lihat semua transaksi</p>
                </div>
            </a>

            <a href="{{ route('owner.laporan_penjualan') }}"
                class="flex items-center gap-4 p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-chart-line text-xl text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Laporan Penjualan</h4>
                    <p class="text-sm text-gray-500">Detail omzet & performa</p>
                </div>
            </a>

            <a href="{{ route('owner.log') }}"
                class="flex items-center gap-4 p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-history text-xl text-purple-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Log Aktivitas</h4>
                    <p class="text-sm text-gray-500">Pantau admin & kasir</p>
                </div>
            </a>

            <a href="{{ route('owner.user') }}"
                class="flex items-center gap-4 p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-users text-xl text-yellow-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Manajemen Users</h4>
                    <p class="text-sm text-gray-500">Tambah & kelola pengguna</p>
                </div>
            </a>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('omzetChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Omzet (Rp)',
                        data: @json($chartData),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: v => {
                                    if (v >= 1000000) return (v / 1000000).toFixed(1) + ' Jt';
                                    if (v >= 1000) return (v / 1000).toFixed(0) + ' Rb';
                                    return v;
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

            // Switch periode via AJAX
            document.getElementById('periodeGrafik').addEventListener('change', async function() {
                const res = await fetch(`{{ route('owner.dashboard.chart') }}?periode=${this.value}`);
                const json = await res.json();

                chart.data.labels = json.labels;
                chart.data.datasets[0].data = json.data;
                chart.update();
            });
        });
    </script>
@endpush
