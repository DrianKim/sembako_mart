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
                            <i class="w-4 h-4 mr-2 fas fa-home"></i>
                            Dashboard
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
                class="flex items-center px-4 py-2.5 text-white bg-gradient-to-r from-green-600 to-green-500 rounded-lg shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </section>

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

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-tags"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Kategori</h3>
                    <p class="text-sm text-gray-600">Total: <span
                            class="font-semibold text-green-600">{{ $kategoris->total() }}</span> kategori</p>
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
                        <th class="text-xs font-semibold tracking-wider text-center text-gray-600 uppercase y-4 2px-6">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @forelse ($kategoris as $index => $kategori)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $kategoris->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">{{ $kategori->nama_kategori }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                        class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori.delete', $kategori->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
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
                            <td colspan="4" class="py-10 text-center text-gray-500">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
            <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                    {{ $kategoris->firstItem() }}-{{ $kategoris->lastItem() }}
                </span> dari
                <span id="totalData" class="font-semibold text-gray-900">{{ $kategoris->total() }}</span>
                kategori
            </div>
            <div class="flex items-center gap-2" id="paginationContainer">
                {{-- Custom Pagination Buttons --}}
                @if ($kategoris->onFirstPage())
                    <button
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                @else
                    <a href="{{ $kategoris->previousPageUrl() }}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                    @if ($page == $kategoris->currentPage())
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($kategoris->hasMorePages())
                    <a href="{{ $kategoris->nextPageUrl() }}"
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

        // 1. REALTIME SEARCH - Fixed selector & logic
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                // Skip "no data" row
                const noDataCell = row.querySelector('td[colspan]');
                const text = row.textContent.toLowerCase();

                if (!noDataCell) { // Data row only
                    if (term === '' || text.includes(term)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            // Update total display dengan selector yang tepat
            const totalEl = document.querySelector('#totalData') ||
                document.querySelector('p.text-sm.text-gray-600 span.font-semibold.text-green-600');
            if (totalEl) {
                totalEl.textContent = visibleCount || '{{ $kategoris->total() }}';
            }
        });

        // 2. RESET BUTTON - Perfect instant clear
        document.getElementById('btnReset').addEventListener('click', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';

            // Trigger search event untuk show semua data
            const inputEvent = new Event('input', {
                bubbles: true
            });
            searchInput.dispatchEvent(inputEvent);
        });

        // 3. ENTER for server-side search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });

        // 4. Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Kategori ini akan dihapus permanen!",
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
