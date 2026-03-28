@forelse ($logs as $index => $log)
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $logs->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            @if ($log->user)
                {{ $log->user->nama }}
                <span
                    class="ml-1 text-xs font-medium px-2 py-0.5 rounded-full
                    {{ $log->user->role === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ ucfirst($log->user->role) }}
                </span>
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>
        <td class="px-6 py-4">
            <div class="text-sm text-gray-900">{{ $log->aktivitas }}</div>
        </td>
        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
            {{ $log->waktu->format('d M Y H:i:s') }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="py-12 text-center text-gray-500">
            <i class="mb-2 text-3xl fas fa-history"></i>
            <p>Belum ada aktivitas yang tercatat</p>
        </td>
    </tr>
@endforelse
