@extends('admin.layouts.app')
@section('title', 'Produk')
@section('page-description', 'Halaman untuk mengelola produk.')

@section('content')
    <!-- Breadcrumb & Header Section -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <!-- Breadcrumb -->
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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Produk</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Create Button -->
            <a href="{{ route('admin.produk.create') }}"
                class="flex items-center px-4 py-2.5 text-white transition-all duration-200 bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Produk
            </a>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:gap-4">
            <!-- Search - span 3 biar lebar dominan -->
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

            <!-- Reset - satu jajar nempel di kanan search -->
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
        <!-- Table Header with Info -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Produk</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">{{ $produks->total() }}</span> produk</span></p>
                </div>
            </div>
            {{-- <div class="flex gap-2">
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
            </div> --}}
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
                    @forelse ($produks as $index => $produk)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $produks->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($produk->foto)
                                    <img src="https://yexkxhepiviphofpsymz.supabase.co/storage/v1/object/public/{{ $produk->foto }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="object-cover w-10 h-10 bg-gray-100 rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-10 h-10 bg-gray-200 rounded-lg">
                                        <i class="text-sm text-gray-500 fas fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $produk->nama_produk }}</div>
                                <div class="text-xs text-gray-500">Barcode: {{ $produk->barcode ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $produk->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-orange-600 whitespace-nowrap">
                                Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600 whitespace-nowrap">
                                Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ $produk->satuan }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.produk.edit', $produk->id) }}"
                                        class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.delete', $produk->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-gray-500">
                                Belum ada data produk.
                            </td>
                        </tr>
                    @endforelse
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
                @if ($produks->onFirstPage())
                    <button
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                @else
                    <a href="{{ $produks->previousPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                    @if ($page == $produks->currentPage())
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($produks->hasMorePages())
                    <a href="{{ $produks->nextPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // SweetAlert session messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                confirmButtonColor: '#10b981',
                background: '#ffffff',
                color: '#1f2937',
                iconColor: '#A5DC86'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true,
                confirmButtonColor: '#ef4444',
                background: '#ffffff',
                color: '#1f2937',
                iconColor: '#ef4444'
            });
        @endif

        // 1. Live Search
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // 2. Reset
        document.getElementById('btnReset').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('#tableBody tr').forEach(row => row.style.display = '');
        });

        // 3. DELETE CONFIRMATION
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus produk?',
                    text: "Data produk akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
