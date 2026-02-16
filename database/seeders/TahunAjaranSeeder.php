<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'is_aktif' => false,
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
            ],
            [
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Genap',
                'is_aktif' => false,
                'tanggal_mulai' => '2025-01-06',
                'tanggal_selesai' => '2025-06-20',
            ],
            [
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Ganjil',
                'is_aktif' => true, // Tahun ajaran saat ini
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2025-12-19',
            ],
        ];

        foreach ($data as $item) {
            TahunAjaran::create($item);
        }
    }
}