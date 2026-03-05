<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $kelompok;
    protected int $rowNumber = 0;

    public function __construct($startDate, $endDate, $kelompok = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->kelompok = $kelompok;
    }

    public function collection()
    {
        $query = Absensi::with(['siswa', 'guru'])
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->kelompok) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelompok', $this->kelompok);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Kelompok',
            'NIS',
            'Tanggal',
            'Status',
            'Keterangan',
            'Guru Pengisi',
            'Waktu Input',
        ];
    }

    public function map($absensi): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $absensi->siswa->nama ?? '-',
            $absensi->siswa->kelompok ?? '-',
            $absensi->siswa->nis ?? '-',
            $absensi->tanggal ? Date::dateTimeToExcel($absensi->tanggal) : null,
            strtoupper($absensi->status ?? '-'),
            $absensi->keterangan ?? '-',
            $absensi->guru->nama ?? '-',
            $absensi->created_at ? Date::dateTimeToExcel($absensi->created_at) : null,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6B46C1'],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Header row height
                $sheet->getRowDimension(1)->setRowHeight(24);

                // Freeze header
                $event->sheet->freezePane('A2');

                // Alignment
                $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C:C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Wrap long text (keterangan)
                $sheet->getStyle('G:G')->getAlignment()->setWrapText(true);

                // Borders for all cells
                $sheet->getStyle('A1:I' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'E5E7EB'],
                        ],
                    ],
                ]);

                // Auto filter
                $sheet->setAutoFilter('A1:I1');

                // Improve readability: set minimum widths for common columns
                $sheet->getColumnDimension('A')->setWidth(6);
                $sheet->getColumnDimension('B')->setWidth(28);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(14);
                $sheet->getColumnDimension('E')->setWidth(14);
                $sheet->getColumnDimension('F')->setWidth(12);
                $sheet->getColumnDimension('G')->setWidth(30);
                $sheet->getColumnDimension('H')->setWidth(22);
                $sheet->getColumnDimension('I')->setWidth(18);

                // Vertically center all rows
                $sheet->getStyle('A1:I' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}