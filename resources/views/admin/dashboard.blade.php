@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-description', 'Halaman utama untuk mengelola sistem toko sembako.')

@section('content')
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama }}!</h1>
                <p class="text-gray-500 text-sm mt-1">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.produk.create') }}"
                    class="flex items-center px-4 py-2.5 text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">
                    <i class="mr-2 fas fa-plus"></i> Tambah Produk
                </a>
                <a href="{{ route('admin.stok') }}"
                    class="flex items-center px-4 py-2.5 text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                    <i class="mr-2 fas fa-boxes"></i> Kelola Stok
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <!-- Omzet Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Omzet Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">
                            Rp {{ number_format($omzetHariIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-wallet text-2xl text-green-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm {{ $persenOmzet >= 0 ? 'text-green-600' : 'text-red-500' }}">
                    <i class="fas fa-arrow-{{ $persenOmzet >= 0 ? 'up' : 'down' }} mr-1"></i>
                    {{ abs($persenOmzet) }}% dari kemarin
                </p>
            </div>

            <!-- Transaksi Hari Ini -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $transaksiHariIni }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full">
                        <i class="fas fa-receipt text-2xl text-blue-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm text-blue-600">
                    Rata-rata Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}/transaksi
                </p>
            </div>

            <!-- Produk Stok Rendah -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk Stok &lt; 10</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $produkStokRendah }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm text-red-500">
                    {{ $produkStokRendah > 0 ? 'Segera lakukan restock!' : 'Stok aman 👍' }}
                </p>
            </div>

            <!-- Kasir Aktif -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kasir Aktif</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $kasirAktif }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-full">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                </div>
                <p class="mt-3 text-sm text-purple-600">Kasir terdaftar & aktif</p>
            </div>
        </div>

        <!-- Chart & Transaksi Terbaru -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Chart Omzet 7 Hari -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📈 Omzet 7 Hari Terakhir</h3>
                <div class="relative h-72">
                    <canvas id="omzetChart"></canvas>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🧾 Transaksi Terbaru</h3>
                <div class="space-y-3">
                    @forelse($transaksiTerbaru as $trx)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                            <div>
                                <p class="font-medium text-gray-800 text-sm">{{ $trx->nomor_unik }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $trx->nama_pelanggan }} • {{ $trx->kasir->nama ?? '-' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600 text-sm">Rp
                                    {{ number_format($trx->total_harga, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-6">Belum ada transaksi hari ini.</p>
                    @endforelse
                </div>
                <a href="{{ route('admin.riwayat_transaksi') }}"
                    class="block mt-4 text-center text-sm text-green-600 hover:underline font-medium">
                    Lihat Semua Transaksi →
                </a>
            </div>
        </div>

        <!-- Produk Hampir Kadaluarsa -->
        @if ($produkHampirKadaluarsa->count() > 0)
            <div class="p-6 bg-white border border-orange-200 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-orange-700 mb-4">⚠️ Produk Hampir Kadaluarsa (7 Hari)</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-2 font-medium">Produk</th>
                                <th class="pb-2 font-medium">No. Batch</th>
                                <th class="pb-2 font-medium">Stok</th>
                                <th class="pb-2 font-medium">Kadaluarsa</th>
                                <th class="pb-2 font-medium">Sisa Hari</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($produkHampirKadaluarsa as $batch)
                                @php $sisaHari = \Carbon\Carbon::today()->diffInDays($batch->tanggal_kadaluarsa, false); @endphp
                                <tr class="hover:bg-orange-50">
                                    <td class="py-2 font-medium text-gray-800">{{ $batch->produk->nama_produk }}</td>
                                    <td class="py-2 text-gray-500">{{ $batch->nomor_batch ?? '-' }}</td>
                                    <td class="py-2">{{ $batch->stok }}</td>
                                    <td class="py-2 text-orange-600">
                                        {{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') }}
                                    </td>
                                    <td class="py-2">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs font-semibold
                                {{ $sisaHari <= 2 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                            {{ $sisaHari }} hari
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Quick Links -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <a href="{{ route('admin.produk') }}"
                class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-box text-xl text-green-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Kelola Produk</h4>
                    <p class="text-sm text-gray-500">Tambah, edit, hapus produk</p>
                </div>
            </a>

            <a href="{{ route('admin.stok') }}"
                class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-boxes text-xl text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Kelola Stok</h4>
                    <p class="text-sm text-gray-500">Cek & tambah stok produk</p>
                </div>
            </a>

            <a href="{{ route('admin.kasir') }}"
                class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-user-tie text-xl text-purple-600"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Kelola Kasir</h4>
                    <p class="text-sm text-gray-500">Tambah / ubah status kasir</p>
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
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Omzet',
                        data: @json($chartData),
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
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
                                    if (value >= 1000000) return (value / 1000000).toFixed(1) + ' Jt';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + ' Rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
