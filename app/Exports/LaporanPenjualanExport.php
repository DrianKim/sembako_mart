<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class LaporanPenjualanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithEvents
{
    protected $from;
    protected $to;
    protected $kasirId;
    protected $kasirNama;
    protected $totalPenjualan;
    protected $jumlahTransaksi;
    protected $rataRata;
    protected $dataCount = 0;

    public function __construct($from, $to, $kasirId = null, $kasirNama = null)
    {
        $this->from    = $from;
        $this->to      = $to;
        $this->kasirId = $kasirId;
        $this->kasirNama = $kasirNama;

        // Hitung summary
        $q = Transaksi::whereBetween('tanggal_transaksi', [$from, $to])
            ->when($kasirId, fn($q) => $q->where('kasir_id', $kasirId));

        $this->totalPenjualan  = $q->sum('total_harga');
        $this->jumlahTransaksi = $q->count();
        $this->rataRata        = $this->jumlahTransaksi > 0
            ? $this->totalPenjualan / $this->jumlahTransaksi
            : 0;
    }

    public function collection()
    {
        $data = Transaksi::with(['kasir'])
            ->whereBetween('tanggal_transaksi', [$this->from, $this->to])
            ->when($this->kasirId, fn($q) => $q->where('kasir_id', $this->kasirId))
            ->latest('tanggal_transaksi')
            ->get();

        $this->dataCount = $data->count();
        return $data;
    }

    public function headings(): array
    {
        // Baris 1-5 = header info, diisi manual di AfterSheet
        // Baris 6 = summary label
        // Baris 7 = summary value
        // Baris 8 = kosong
        // Baris 9 = heading kolom tabel  <-- ini yang dikembaliin
        return ['No', 'Tanggal', 'Kasir', 'Pelanggan', 'Nomor Unik', 'Total (Rp)'];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            Carbon::parse($row->tanggal_transaksi)->format('d/m/Y H:i'),
            $row->kasir?->nama ?? '-',
            $row->nama_pelanggan ?? '-',
            $row->nomor_unik ?? '-',
            (float) $row->total_harga,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Dihandle semua di registerEvents / AfterSheet
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $dataCount = $this->dataCount;

                // ── Sisipkan 8 baris di atas (header info + summary) ──
                $sheet->insertNewRowBefore(1, 8);

                // Row 1: Judul
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(35);

                // Row 2: Periode
                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'Periode: ' . $this->from->format('d M Y') . ' - ' . $this->to->format('d M Y'));
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['size' => 10, 'color' => ['rgb' => '6b7280']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Row 3: Kasir (kalau ada filter kasir)
                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', $this->kasirNama ? 'Kasir: ' . $this->kasirNama : '');
                $sheet->getStyle('A3')->applyFromArray([
                    'font'      => ['size' => 10, 'color' => ['rgb' => '6b7280']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Row 4: Kosong (spacer)
                $sheet->mergeCells('A4:F4');
                $sheet->getStyle('A4')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                ]);

                // Row 5-6: Summary cards (label + value)
                $summaryStyle = [
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
                    'font'      => ['size' => 9, 'color' => ['rgb' => '64748b']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'd1fae5']]],
                ];
                $valueStyle = [
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF4']],
                    'font'      => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '10B981']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'd1fae5']]],
                ];

                // Label
                $sheet->mergeCells('A5:B5');
                $sheet->setCellValue('A5', 'Total Penjualan');
                $sheet->getStyle('A5:B5')->applyFromArray($summaryStyle);

                $sheet->mergeCells('C5:D5');
                $sheet->setCellValue('C5', 'Jumlah Transaksi');
                $sheet->getStyle('C5:D5')->applyFromArray($summaryStyle);

                $sheet->mergeCells('E5:F5');
                $sheet->setCellValue('E5', 'Rata-rata / Transaksi');
                $sheet->getStyle('E5:F5')->applyFromArray($summaryStyle);

                // Value
                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'Rp ' . number_format($this->totalPenjualan, 0, ',', '.'));
                $sheet->getStyle('A6:B6')->applyFromArray($valueStyle);

                $sheet->mergeCells('C6:D6');
                $sheet->setCellValue('C6', $this->jumlahTransaksi);
                $sheet->getStyle('C6:D6')->applyFromArray($valueStyle);

                $sheet->mergeCells('E6:F6');
                $sheet->setCellValue('E6', 'Rp ' . number_format($this->rataRata, 0, ',', '.'));
                $sheet->getStyle('E6:F6')->applyFromArray($valueStyle);

                $sheet->getRowDimension(5)->setRowHeight(20);
                $sheet->getRowDimension(6)->setRowHeight(25);

                // Row 7: Kosong (spacer)
                $sheet->mergeCells('A7:F7');
                $sheet->getStyle('A7')->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
                ]);

                // ── Row 8: Heading tabel (sudah ada dari WithHeadings, tinggal style) ──
                $headingRow = 8;
                $sheet->getStyle("A{$headingRow}:F{$headingRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '10B981']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '059669']]],
                ]);
                $sheet->getRowDimension($headingRow)->setRowHeight(22);

                // ── Alternating rows data ──
                $dataStartRow = $headingRow + 1;
                $dataEndRow   = $dataStartRow + $dataCount - 1;

                for ($i = $dataStartRow; $i <= $dataEndRow; $i++) {
                    $color = ($i % 2 === 0) ? 'F0FDF4' : 'FFFFFF';
                    $sheet->getStyle("A{$i}:F{$i}")->applyFromArray([
                        'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'e5e7eb']]],
                        'font'    => ['size' => 9],
                    ]);
                    $sheet->getRowDimension($i)->setRowHeight(18);
                }

                // Kolom total (F) format number
                if ($dataCount > 0) {
                    $sheet->getStyle("F{$dataStartRow}:F{$dataEndRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                }

                // ── Total row ──
                if ($dataCount > 0) {
                    $totalRow = $dataEndRow + 1;
                    $sheet->setCellValue("A{$totalRow}", '');
                    $sheet->mergeCells("A{$totalRow}:E{$totalRow}");
                    $sheet->setCellValue("A{$totalRow}", 'GRAND TOTAL');
                    $sheet->setCellValue("F{$totalRow}", (float) $this->totalPenjualan);
                    $sheet->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray([
                        'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '065f46']],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D1FAE5']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '10B981']]],
                    ]);
                    $sheet->getStyle("F{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                    $sheet->getRowDimension($totalRow)->setRowHeight(22);
                }

                // ── Footer ──
                $footerRow = ($dataCount > 0 ? $dataEndRow + 2 : $dataStartRow + 1);
                $sheet->mergeCells("A{$footerRow}:F{$footerRow}");
                $sheet->setCellValue("A{$footerRow}", 'Dicetak pada: ' . now()->format('d F Y H:i') . ' WIB');
                $sheet->getStyle("A{$footerRow}")->applyFromArray([
                    'font'      => ['size' => 8, 'italic' => true, 'color' => ['rgb' => '9ca3af']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                ]);

                // Freeze pane di heading
                $sheet->freezePane("A{$dataStartRow}");
            },
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}
