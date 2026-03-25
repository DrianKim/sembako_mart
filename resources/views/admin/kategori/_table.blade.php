@forelse ($kategoris as $index => $kategori)
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900">
            {{ $kategoris->firstItem() + $index }}
        </td>
        <td class="px-6 py-4">
            <div class="text-sm font-semibold text-gray-900">{{ $kategori->nama_kategori }}</div>
        </td>
        <td class="px-6 py-4 text-center">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                    class="p-2 text-blue-600 rounded-lg bg-blue-50 hover:bg-blue-100">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.kategori.delete', $kategori->id) }}" method="POST"
                    class="inline delete-form">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 rounded-lg bg-red-50 hover:bg-red-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="py-10 text-center text-gray-500">Belum ada data kategori.</td>
    </tr>
@endforelse
