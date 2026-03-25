@if ($kategoris->onFirstPage())
    <button
        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
        disabled>
        <i class="fas fa-chevron-left"></i> Previous
    </button>
@else
    <a href="#" data-page="{{ $kategoris->currentPage() - 1 }}"
        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg pagination-link hover:bg-gray-50">
        <i class="fas fa-chevron-left"></i> Previous
    </a>
@endif

@foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
    <a href="#" data-page="{{ $page }}"
        class="pagination-link px-4 py-2 text-sm font-medium border rounded-lg
        {{ $page == $kategoris->currentPage() ? 'text-white bg-green-600 border-green-600 hover:bg-green-700' : 'text-gray-700 bg-white border-gray-300 hover:bg-gray-50' }}">
        {{ $page }}
    </a>
@endforeach

@if ($kategoris->hasMorePages())
    <a href="#" data-page="{{ $kategoris->currentPage() + 1 }}"
        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg pagination-link hover:bg-gray-50">
        Next <i class="fas fa-chevron-right"></i>
    </a>
@else
    <button
        class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
        disabled>
        Next <i class="fas fa-chevron-right"></i>
    </button>
@endif
