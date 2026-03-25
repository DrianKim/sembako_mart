@forelse ($kasirs as $index => $kasir)
    <tr class="transition-colors hover:bg-gray-50" data-kasir-id="{{ $kasir->id }}"
        data-nama="{{ strtolower($kasir->nama) }}" data-username="{{ strtolower($kasir->username) }}"
        data-nohp="{{ $kasir->no_hp ?? '' }}" data-status="{{ $kasir->status }}">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $kasirs->firstItem() + $index }}
        </td>
        <td class="px-6 py-4">
            <div class="text-sm font-semibold text-gray-900">{{ $kasir->nama }}</div>
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-900">{{ $kasir->username }}</div>
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-900">{{ $kasir->no_hp ?? '-' }}</div>
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            @if ($kasir->status == 'aktif')
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                    Aktif
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                    <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                    Nonaktif
                </span>
            @endif
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.kasir.edit', $kasir->id) }}"
                    class="p-2 text-blue-600 rounded-lg bg-blue-50 hover:bg-blue-100" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" onclick="toggleKasirStatus({{ $kasir->id }})"
                    class="{{ $kasir->status == 'aktif' ? 'text-green-600 bg-green-50 hover:bg-green-100' : 'text-red-400 bg-red-50 hover:bg-red-100' }} p-2 rounded-lg"
                    title="Toggle Status">
                    <i class="fas {{ $kasir->status == 'aktif' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr id="noResultRow">
        <td colspan="6" class="py-12 text-center text-gray-500">
            <i class="mb-2 text-3xl fas fa-users"></i>
            <p>Belum ada data kasir</p>
        </td>
    </tr>
@endforelse
