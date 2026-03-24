<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpmbExport implements FromCollection, WithHeadings
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK Anak',
            'Nama Lengkap',
            'Tempat, Tanggal Lahir',
            'Umur',
            'Jenis Kelamin',
            'Agama',
            'Nama Ayah',
            'NIK Ayah',
            'Pekerjaan Ayah',
            'No HP Ayah',
            'Nama Ibu',
            'NIK Ibu',
            'Pekerjaan Ibu',
            'No HP Ibu',
            'Alamat Lengkap',
            'Nama Wali',
            'NIK Wali',
            'Pekerjaan Wali',
            'No HP Wali',
        ];
    }
}
