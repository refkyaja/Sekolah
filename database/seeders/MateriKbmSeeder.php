<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MateriKbm;
use Carbon\Carbon;

class MateriKbmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'mata_pelajaran' => 'Baca',
                'judul_materi' => 'Mengenal Huruf Vokal',
                'kelas' => 'Kelompok A',
                'kelompok' => 'A1',
                'file_name' => 'belajar_vokal.pdf',
                'file_type' => 'PDF Document',
                'file_size' => 1024 * 540, // 540 KB
                'deskripsi' => 'Materi dasar mengenal huruf a, i, u, e, o dengan gambar yang menarik.',
                'tanggal_publish' => Carbon::now()->subDays(2),
            ],
            [
                'mata_pelajaran' => 'Tulis',
                'judul_materi' => 'Latihan Menulis Garis Lurus',
                'kelas' => 'Kelompok A',
                'kelompok' => 'A1',
                'file_name' => 'menulis_garis.pdf',
                'file_type' => 'PDF Document',
                'file_size' => 1024 * 1200, // 1.2 MB
                'deskripsi' => 'Panduan menebalkan garis lurus dan lengkung untuk melatih motorik halus.',
                'tanggal_publish' => Carbon::now()->subDays(1),
            ],
            [
                'mata_pelajaran' => 'Menghitung',
                'judul_materi' => 'Mengenal Angka 1 sampai 10',
                'kelas' => 'Kelompok A',
                'kelompok' => 'A1',
                'file_name' => 'angka_1_10.pptx',
                'file_type' => 'PowerPoint',
                'file_size' => 1024 * 1024 * 3.5, // 3.5 MB
                'deskripsi' => 'Presentasi interaktif mengenal lambang bilangan 1-10.',
                'tanggal_publish' => Carbon::now(),
            ],
            [
                'mata_pelajaran' => 'Baca',
                'judul_materi' => 'Membaca Suku Kata Terbuka',
                'kelas' => 'Kelompok B',
                'kelompok' => 'B1',
                'file_name' => 'suku_kata.pdf',
                'file_type' => 'PDF Document',
                'file_size' => 1024 * 850,
                'deskripsi' => 'Latihan membaca gabungan huruf konsonan dan vokal (ba-bi-bu-be-bo).',
                'tanggal_publish' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($materials as $materi) {
            MateriKbm::create($materi);
        }
    }
}
