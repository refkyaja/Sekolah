<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunSekarang = date('Y');
        $tahunDepan = $tahunSekarang + 1;
        
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
                'is_aktif' => false,
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2025-12-19',
            ],
            [
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Genap',
                'is_aktif' => false,
                'tanggal_mulai' => '2026-01-05',
                'tanggal_selesai' => '2026-06-19',
            ],
            [
                'tahun_ajaran' => $tahunSekarang . '/' . $tahunDepan,
                'semester' => 'Ganjil',
                'is_aktif' => true,
                'tanggal_mulai' => $tahunSekarang . '-07-13',
                'tanggal_selesai' => $tahunSekarang . '-12-18',
            ],
        ];

        foreach ($data as $item) {
            TahunAjaran::updateOrCreate(
                ['tahun_ajaran' => $item['tahun_ajaran'], 'semester' => $item['semester']],
                $item
            );
        }
    }
}
