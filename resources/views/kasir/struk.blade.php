<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi {{ $trxNumber }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                font-family: 'Courier New', Courier, monospace;
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .struk-container {
                width: 80mm;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body class="p-6 bg-gray-100 no-print">
    <div
        class="max-w-md p-6 mx-auto bg-white rounded-lg shadow-lg struk-container print:bg-white print:shadow-none print:p-0">
        <div class="mb-4 text-center">
            <h1 class="text-xl font-bold">Sembako Mart</h1>
            <p class="text-sm text-gray-600">Subang, Jawa Barat</p>
            <p class="text-sm">Telp: 0812-3456-7890</p>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <div class="text-sm">
            <div class="flex justify-between">
                <span>Nomor Transaksi</span>
                <span class="font-mono">{{ $trxNumber }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $tanggal }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span>{{ $kasir }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pelanggan</span>
                <span>{{ $pelanggan }}</span>
            </div>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <!-- Detail Item -->
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
                    @foreach ($items as $item)
                        <tr>
                            <td class="py-1">{{ $item['nama'] }}</td>
                            <td class="py-1 text-center">{{ $item['qty'] }}</td>
                            <td class="py-1 text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="py-1 font-semibold text-right">Rp
                                {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-bold border-t border-gray-400">
                        <td colspan="3" class="py-2 text-right">Total</td>
                        <td class="py-2 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <div class="text-sm">
            <div class="flex justify-between">
                <span>Uang Bayar</span>
                <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Kembalian</span>
                <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <hr class="my-3 border-gray-400 border-dashed">

        <div class="mt-4 text-xs text-center text-gray-600">
            Terima kasih atas kunjungan Anda!<br>
            Barang yang sudah dibeli tidak bisa ditukar / dikembalikan.<br>
            <br>
            ** STRUK INI BUKAN FAKTUR PAJAK **
        </div>
    </div>

    <!-- Tombol (hilang saat print) -->
    <div class="mt-6 text-center no-print">
        <button onclick="window.print()"
            class="px-8 py-3 text-white transition-all bg-green-600 rounded-lg shadow-md hover:bg-green-700">
            <i class="mr-2 fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('kasir.transaksi') }}"
            class="inline-block px-6 py-3 ml-4 text-gray-700 transition-all bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali ke Transaksi
        </a>
    </div>

    <script>
        // Auto print opsional (uncomment kalo mau langsung cetak pas buka halaman)
        // window.onload = function() { window.print(); };
    </script>
</body>

</html>
