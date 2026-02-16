<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $kelompok;

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
            'Nama Siswa',
            'Kelompok',
            'Tanggal',
            'Status',
            'Keterangan',
            'Guru Pengisi',
            'Waktu Input',
        ];
    }

    public function map($absensi): array
    {
        return [
            $absensi->siswa->nama,
            $absensi->siswa->kelompok,
            $absensi->tanggal->format('d/m/Y'),
            strtoupper($absensi->status),
            $absensi->keterangan ?? '-',
            $absensi->guru->nama,
            $absensi->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}