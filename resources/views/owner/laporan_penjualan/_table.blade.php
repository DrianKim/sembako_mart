@forelse ($transaksis as $index => $trx)
    <tr class="transition-colors hover:bg-gray-50">
        <td class="w-12 px-6 py-4 text-sm font-medium text-gray-900">
            {{ $transaksis->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
            {{ $trx->tanggal_transaksi->format('d M Y H:i') }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            {{ $trx->kasir?->nama ?? '-' }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            {{ $trx->nama_pelanggan ?? 'Umum' }}
        </td>
        <td class="px-6 py-4 font-mono text-sm text-gray-900">
            {{ $trx->nomor_unik }}
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-right text-gray-900 whitespace-nowrap">
            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <a href="{{ route('owner.laporan_penjualan.struk', $trx->id) }}" target="_blank"
                class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                title="Cetak Struk">
                <i class="fas fa-print"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="py-10 text-center text-gray-500">
            <i class="mr-2 fas fa-inbox"></i> Belum ada transaksi pada periode ini.
        </td>
    </tr>
@endforelse
