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
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i>
                    Cari Transaksi
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama pelanggan, nomor unik, atau tanggal..."
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button id="btnFilter"
                class="flex items-center px-4 py-2 text-white transition-all bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="mr-2 fas fa-search"></i> Terapkan
            </button>
            <button id="btnReset"
                class="flex items-center px-4 py-2 text-gray-700 transition-all bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <i class="mr-2 fas fa-redo"></i> Reset
            </button>
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
                    <p class="text-sm text-gray-600">Total: <span class="font-semibold text-green-600">6</span> transaksi
                    </p>
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
                    <!-- Dummy Row 1 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">1</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 14:45:00</td>
                        <td class="px-6 py-4 text-sm text-gray-900">andi_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Budi</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">TRX-20260220-001</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 185.000</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.riwayat_transaksi.edit', 1) }}"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Transaksi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.riwayat_transaksi.struk', 1) }}" target="_blank"
                                    class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                    title="Cetak Struk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 2 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">2</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 15:30:22</td>
                        <td class="px-6 py-4 text-sm text-gray-900">siti_kasir01</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Ani</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">TRX-20260220-002</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 92.500</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Transaksi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#"
                                    class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                    title="Cetak Struk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Row 3 -->
                    <tr class="transition-colors hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">3</td>
                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">2026-02-20 16:10:55</td>
                        <td class="px-6 py-4 text-sm text-gray-900">andi_kasir</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rina</td>
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">TRX-20260220-003</td>
                        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900">Rp 450.000</td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2">
                                <a href="#"
                                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                    title="Edit Transaksi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#"
                                    class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                    title="Cetak Struk">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Tambah dummy lain sesuai kebutuhan -->
                </tbody>
            </table>
        </div>

        <!-- Pagination Dummy -->
        <div
            class="flex flex-col items-center justify-between px-6 py-4 text-sm text-gray-600 border-t bg-gray-50 sm:flex-row">
            <div class="mb-4 sm:mb-0">Menampilkan <span class="font-semibold text-gray-900">1-3</span> dari <span
                    class="font-semibold text-gray-900">20</span> transaksi</div>
            <div class="flex items-center gap-2">
                <button class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50"
                    disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <button
                    class="px-4 py-2 text-white bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">1</button>
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Select All
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('tbody input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
        });

        // Live Search
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('#tableBody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });

        // Reset
        document.getElementById('btnReset')?.addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('#tableBody tr').forEach(row => row.style.display = '');
        });
    </script>
@endpush
