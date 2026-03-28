@forelse ($transaksis as $index => $trx)
    <tr class="transition-colors hover:bg-gray-50">
        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
            {{ $transaksis->firstItem() + $index }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
            {{ $trx->tanggal_transaksi->format('d M Y H:i') }} WIB
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            {{ $trx->kasir->nama ?? '-' }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
            {{ $trx->nama_pelanggan }}
        </td>
        <td class="px-6 py-4 font-mono text-sm text-gray-900">
            {{ $trx->nomor_unik }}
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-right text-green-600 whitespace-nowrap">
            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
        </td>
        <td class="px-6 py-4 text-center whitespace-nowrap">
            <div class="flex justify-center gap-2">
                <a href="{{ route('admin.riwayat_transaksi.edit', $trx->id) }}"
                    class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
                    title="Edit Transaksi">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('admin.riwayat_transaksi.struk', $trx->id) }}" target="_blank"
                    class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                    title="Cetak Struk">
                    <i class="fas fa-print"></i>
                </a>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="py-10 text-center text-gray-500">
            Belum ada riwayat transaksi.
        </td>
    </tr>
@endforelse
