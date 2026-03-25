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
        <td class="px-6 py-4 text-center whitespace-nowrap">
            @if ($produk->stok > 15)
                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                    {{ number_format($produk->stok) }}
                </span>
            @elseif ($produk->stok > 5)
                <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                    {{ number_format($produk->stok) }}
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                    {{ number_format($produk->stok) }}
                </span>
            @endif
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <div class="flex justify-center gap-2">
                <!-- Tambah Stok -->
                <a href="{{ route('admin.stok.create', $produk->id) }}"
                    class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                    title="Tambah Stok">
                    <i class="fas fa-plus"></i>
                </a>
                <!-- Edit Produk -->
                <a href="{{ route('admin.stok.edit', $produk->id) }}"
                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                    title="Edit Produk">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="py-12 text-center text-gray-500">
            <i class="mb-2 text-3xl fas fa-boxes"></i>
            <p>Belum ada data stok produk</p>
        </td>
    </tr>
@endforelse
