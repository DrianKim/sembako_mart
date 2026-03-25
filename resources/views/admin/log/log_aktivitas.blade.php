@extends('admin.layouts.app')
@section('title', 'Log Aktivitas')
@section('page-description', 'Riwayat aktivitas Anda sebagai admin.')

@section('content')
    <!-- Breadcrumb & Header -->
    <section class="mb-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <nav class="flex mb-4 md:mb-0" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="w-4 h-4 mr-2 fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="w-6 h-6 text-gray-400 fas fa-chevron-right"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Log Aktivitas</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <div class="p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 md:gap-4">
            <!-- Search -->
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="mr-1 text-green-600 fas fa-search"></i> Cari Aktivitas
                </label>
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan deskripsi aktivitas..."
                        value="{{ $search ?? '' }}"
                        class="w-full px-4 py-2.5 pl-10 text-gray-700 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="text-gray-400 fas fa-search"></i>
                    </div>
                </div>
            </div>

            <!-- Reset -->
            <div class="flex items-end justify-end md:col-span-1">
                <button id="btnReset"
                    class="flex items-center px-6 py-2.5 text-gray-700 transition-all duration-200 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 shadow-sm">
                    <i class="mr-2 fas fa-redo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Table Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 mr-3 bg-green-100 rounded-lg">
                    <i class="text-xl text-green-600 fas fa-history"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Aktivitas Saya</h3>
                    <p class="text-sm text-gray-600">Total: <span id="totalData"
                            class="font-semibold text-green-600">{{ $logs->total() }}</span> aktivitas</p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase">
                            Aktivitas</th>
                        <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase ">
                            Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                    @forelse($logs as $index => $log)
                        <tr class="transition-colors hover:bg-gray-50" data-log-id="{{ $log->id }}">
                            <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $logs->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $log->aktivitas }}</div>
                                @if ($log->user)
                                    <div class="mt-1 text-xs text-gray-500">
                                        <i class="mr-1 fas fa-user"></i> {{ $log->user->nama }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ $log->waktu->format('d M Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-12 text-center text-gray-500">
                                <i class="mb-2 text-3xl fas fa-history"></i>
                                <p>Belum ada aktivitas yang tercatat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <div
                    class="flex flex-col items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50 sm:flex-row">
                    <div class="mb-4 text-sm text-gray-600 sm:mb-0">
                        Menampilkan <span id="pageInfo" class="font-semibold text-gray-900">
                            {{ $logs->firstItem() }}-{{ $logs->lastItem() }}
                        </span> dari
                        <span id="totalData" class="font-semibold text-gray-900">{{ $logs->total() }}</span>
                        aktivitas
                    </div>
                    <div class="flex items-center gap-2" id="paginationContainer">
                        {{-- Previous --}}
                        @if ($logs->onFirstPage())
                            <button
                                class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                <i class="fas fa-chevron-left"></i> Previous
                            </button>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}"
                                class="px-3 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <a href="{{ $url }}"
                                    class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 border border-green-600 rounded-lg hover:bg-green-700">{{ $page }}</a>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}"
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

            </table>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        let currentSearch = '{{ $search ?? '' }}';

        // Live Search (client-side)
        document.getElementById('searchInput').addEventListener('input', debounce(function(e) {
            currentSearch = e.target.value;
            applyFilters();
        }, 300));

        // Server-side search on Enter
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                window.location.href = `{{ route('admin.log') }}?search=${encodeURIComponent(this.value)}`;
            }
        });

        // Reset
        document.getElementById('btnReset').addEventListener('click', function() {
            window.location.href = '{{ route('admin.log') }}';
        });

        function applyFilters() {
            const term = currentSearch.toLowerCase().trim();
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const noDataCell = row.querySelector('td[colspan]');
                if (noDataCell) return;

                const text = row.textContent.toLowerCase();
                const showRow = !term || text.includes(term);

                row.style.display = showRow ? '' : 'none';
                if (showRow) visibleCount++;
            });

            document.getElementById('totalData').textContent = visibleCount || '{{ $logs->total() }}';
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
@endpush
