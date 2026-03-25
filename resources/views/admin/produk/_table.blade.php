@forelse ($produks as $index => $produk)
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $produks->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($produk->foto)
                <img src="https://yexkxhepiviphofpsymz.supabase.co/storage/v1/object/public/{{ $produk->foto }}"
                    alt="{{ $produk->nama_produk }}" class="object-cover w-10 h-10 bg-gray-100 rounded-lg">
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
        <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
        <td class="px-6 py-4 text-sm font-semibold text-orange-600 whitespace-nowrap">
            Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-green-600 whitespace-nowrap">
            Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $produk->satuan }}</td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.produk.edit', $produk->id) }}"
                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.produk.delete', $produk->id) }}" method="POST"
                    class="inline delete-form">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="py-10 text-center text-gray-500">Belum ada data produk.</td>
    </tr>
@endforelse
