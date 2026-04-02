@forelse ($produks as $index => $produk)
    @php
        $totalStok = $produk->total_stok; // dari accessor di model Produk
        $adaKadaluarsa = $produk->batchProduks
            ->filter(fn($b) => $b->tanggal_kadaluarsa && \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast())
            ->count();
        $mendekatiKadaluarsa = $produk->batchProduks
            ->filter(
                fn($b) => $b->tanggal_kadaluarsa &&
                    !\Carbon\Carbon::parse($b->tanggal_kadaluarsa)->isPast() &&
                    \Carbon\Carbon::parse($b->tanggal_kadaluarsa)->diffInDays(now()) <= 7
            )
            ->count();
    @endphp
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $produks->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($produk->foto)
                <img src="{{ url($produk->foto) }}"
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
            @if ($adaKadaluarsa > 0)
                <span class="inline-block px-2 py-0.5 mt-1 text-xs font-medium text-white bg-red-500 rounded-full">
                    <i class="mr-1 fas fa-exclamation-circle"></i>{{ $adaKadaluarsa }} batch kadaluarsa
                </span>
            @elseif ($mendekatiKadaluarsa > 0)
                <span class="inline-block px-2 py-0.5 mt-1 text-xs font-medium text-white bg-yellow-500 rounded-full">
                    <i class="mr-1 fas fa-clock"></i>{{ $mendekatiKadaluarsa }} batch segera kadaluarsa
                </span>
            @endif
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            @if ($totalStok > 15)
                <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                    {{ number_format($totalStok) }}
                </span>
            @elseif ($totalStok > 5)
                <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                    {{ number_format($totalStok) }}
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                    {{ number_format($totalStok) }}
                </span>
            @endif
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <a href="{{ route('admin.stok.edit', $produk->id) }}"
                class="inline-flex items-center gap-1 px-3 py-2 text-sm text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                title="Kelola Stok & Batch">
                <i class="fas fa-edit"></i>
                <span class="hidden sm:inline">Kelola</span>
            </a>
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
