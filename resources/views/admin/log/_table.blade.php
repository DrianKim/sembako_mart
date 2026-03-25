@forelse ($logs as $index => $log)
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
    <tr id="noResultRow">
        <td colspan="3" class="py-12 text-center text-gray-500">
            <i class="mb-2 text-3xl fas fa-history"></i>
            <p>Belum ada aktivitas yang tercatat</p>
        </td>
    </tr>
@endforelse
