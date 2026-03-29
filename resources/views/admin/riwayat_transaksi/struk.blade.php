<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi {{ $transaksi->nomor_unik }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                font-family: 'Courier New', Courier, monospace !important;
                font-size: 12px !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .struk-container {
                width: 80mm !important;
                margin: 0 auto !important;
                padding: 0 !important;
                background: white !important;
                box-shadow: none !important;
            }

            body * {
                visibility: hidden;
            }

            .struk-container,
            .struk-container * {
                visibility: visible;
            }

            .struk-container {
                max-width: 80mm;
            }

            .text-center {
                text-align: center !important;
            }

            .text-sm {
                font-size: 12px !important;
            }

            .text-xs {
                font-size: 10px !important;
            }

            .font-bold {
                font-weight: bold !important;
            }

            .font-mono {
                font-family: monospace !important;
            }

            .flex {
                display: flex !important;
            }

            .justify-between {
                justify-content: space-between !important;
            }

            .mb-4 {
                margin-bottom: 16px !important;
            }

            .my-3 {
                margin-top: 12px !important;
                margin-bottom: 12px !important;
            }

            .py-1 {
                padding-top: 4px !important;
                padding-bottom: 4px !important;
            }

            .py-2 {
                padding-top: 8px !important;
                padding-bottom: 8px !important;
            }

            hr {
                border: 0 !important;
                border-top: 1px dashed #9ca3af !important;
                margin: 12px 0 !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            th,
            td {
                padding: 4px 0 !important;
                text-align: left !important;
            }

            th {
                font-weight: bold !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }
        }
    </style>
</head>

<body class="p-6 bg-gray-100">

    <div class="max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg struk-container">

        <!-- Header Toko -->
        <div class="mb-4 text-center">
            <h1 class="text-xl font-bold">Sembako Mart</h1>
            <p class="text-sm text-gray-600">Subang, Jawa Barat</p>
            <p class="text-sm">Telp: 0812-3456-7890</p>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <!-- Info Transaksi -->
        <div class="text-sm">
            <div class="flex justify-between">
                <span>Nomor Transaksi</span>
                <span class="font-mono">{{ $transaksi->nomor_unik }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $transaksi->tanggal_transaksi->format('d M Y H:i') }} WIB</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ $transaksi->kasir->nama ?? 'Kasir' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pelanggan</span>
                <span>{{ $transaksi->nama_pelanggan }}</span>
            </div>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <!-- Daftar Item -->
        <div class="text-sm">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="py-1 text-left">Produk</th>
                        <th class="py-1 text-center">Qty</th>
                        <th class="py-1 text-right">Harga</th>
                        <th class="py-1 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->detailTransaksi as $detail)
                        <tr>
                            <td class="py-1">{{ $detail->produk->nama_produk }}</td>
                            <td class="py-1 text-center">{{ $detail->qty }}</td>
                            <td class="py-1 text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-1 font-semibold text-right">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="font-bold border-t border-gray-400">
                        <td colspan="3" class="py-2 text-right">Total</td>
                        <td class="py-2 text-right">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <!-- Pembayaran -->
        <div class="text-sm">
            <div class="flex justify-between">
                <span>Uang Bayar</span>
                <span>Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaksi->uang_kembali, 0, ',', '.') }}</span>
            </div>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <!-- Footer -->
        <div class="mt-4 text-xs text-center text-gray-600">
            Terima kasih atas kunjungan Anda!<br>
            Barang yang sudah dibeli tidak bisa ditukar / dikembalikan.<br>
            <br>
            ** STRUK INI BUKAN FAKTUR PAJAK **
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="mt-6 text-center no-print">
        <button onclick="window.print()"
            class="px-8 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700">
            <i class="mr-2 fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('admin.riwayat_transaksi') }}"
            class="inline-block px-6 py-3 ml-4 text-gray-700 transition-all bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali
        </a>
    </div>

</body>

</html>
