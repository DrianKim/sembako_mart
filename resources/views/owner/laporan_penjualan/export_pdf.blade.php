<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        @page {
            margin: 12mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 8pt;
            color: #1f2937;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #10B981;
        }

        .header h1 {
            font-size: 13pt;
            color: #10B981;
            margin: 0;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 3px;
        }

        /* DomPDF ga support flexbox, pakai table bro */
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin: 10px 0;
        }

        .summary-table td {
            width: 33.33%;
            background: #f0fdf4;
            border: 1px solid #d1fae5;
            border-radius: 4px;
            padding: 7px 10px;
            vertical-align: top;
        }

        .summary-table .label {
            font-size: 7pt;
            color: #64748b;
            margin-bottom: 3px;
        }

        .summary-table .value {
            font-size: 10pt;
            font-weight: bold;
            color: #10B981;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.data-table thead {
            background-color: #10B981;
            color: white;
        }

        table.data-table thead th {
            padding: 6px 8px;
            text-align: left;
            font-size: 7.5pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table.data-table tbody td {
            padding: 5px 8px;
            font-size: 8pt;
            border-bottom: 1px solid #e5e7eb;
        }

        table.data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row td {
            background-color: #d1fae5;
            font-weight: bold;
            color: #065f46;
            padding: 6px 8px;
            font-size: 8pt;
        }

        .footer {
            margin-top: 16px;
            text-align: right;
            font-size: 7pt;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p class="subtitle">Periode: {{ $periodeLabel }}</p>
        @if ($kasirNama)
            <p class="subtitle">Kasir: {{ $kasirNama }}</p>
        @endif
    </div>


    <table class="summary-table">
        <tr>
            <td>
                <div class="label">Total Penjualan</div>
                <div class="value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">Jumlah Transaksi</div>
                <div class="value">{{ $jumlahTransaksi }}</div>
            </td>
            <td>
                <div class="label">Rata-rata per Transaksi</div>
                <div class="value">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Total Modal</div>
                <div class="value" style="color: #f97316;">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
            </td>
            <td colspan="2">
                <div class="label">Laba Bersih</div>
                <div class="value" style="color: {{ $labaBersih >= 0 ? '#10B981' : '#ef4444' }};">
                    Rp {{ number_format($labaBersih, 0, ',', '.') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 100px;">Tanggal</th>
                <th>Kasir</th>
                <th>Pelanggan</th>
                <th>Nomor Unik</th>
                <th class="text-right" style="width: 110px;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $t)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->kasir?->nama ?? '-' }}</td>
                    <td>{{ $t->nama_pelanggan ?? '-' }}</td>
                    <td>{{ $t->nomor_unik ?? '-' }}</td>
                    <td class="text-right">{{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #9ca3af;">
                        Tidak ada data transaksi dalam periode ini.
                    </td>
                </tr>
            @endforelse

            @if ($transaksis->count() > 0)
                <tr class="total-row">
                    <td colspan="5" class="text-right">GRAND TOTAL</td>
                    <td class="text-right">{{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y H:i') }} WIB
    </div>

</body>

</html>
