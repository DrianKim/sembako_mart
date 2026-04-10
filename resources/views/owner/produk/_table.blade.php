@forelse ($produks as $index => $produk)
    @php
        $totalStok = $produk->batchProduks->sum('stok');
        $hargaBeli = $produk->batchProduks->last()?->harga_beli ?? 0;
        $adaKadaluarsa = $produk->batchProduks
            ->filter(fn($b) => $b->tanggal_kadaluarsa && \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast())
            ->count();
        $mendekatiKadaluarsa = $produk->batchProduks
            ->filter(
                fn($b) => $b->tanggal_kadaluarsa &&
                    !\Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast() &&
                    \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->diffInDays(now()) <= 30,
            )
            ->count();
    @endphp
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $produks->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($produk->foto)
                <img src="{{ url($produk->foto) }}" alt="{{ $produk->nama_produk }}"
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
            @if ($adaKadaluarsa > 0)
                <span class="inline-block px-2 py-0.5 mt-1 text-xs font-medium text-white bg-red-500 rounded-full">
                    <i class="mr-1 fas fa-exclamation-circle"></i>{{ $adaKadaluarsa }} batch kadaluarsa
                </span>
            {{-- @elseif ($mendekatiKadaluarsa > 0)
                <span class="inline-block px-2 py-0.5 mt-1 text-xs font-medium text-white bg-yellow-500 rounded-full">
                    <i class="mr-1 fas fa-clock"></i>{{ $mendekatiKadaluarsa }} batch segera kadaluarsa
                </span> --}}
            @endif
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
        <td class="px-6 py-4 text-sm font-semibold text-orange-600 whitespace-nowrap">
            Rp {{ number_format($hargaBeli, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-green-600 whitespace-nowrap">
            Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $produk->satuan }}</td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            @if ($totalStok == 0)
                <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                    0 (Habis)
                </span>
            @elseif ($totalStok <= 10)
                <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                    {{ number_format($totalStok) }} {{ $produk->satuan }}
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                    {{ number_format($totalStok) }} {{ $produk->satuan }}
                </span>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="py-10 text-center text-gray-500">Belum ada data produk.</td>
    </tr>
@endforelse
