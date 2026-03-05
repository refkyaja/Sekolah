<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\KalenderAkademik;
use Carbon\Carbon;

class KalenderAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = 2023;
        $month = 10;

        $events = [
            ['judul' => 'Makan Bersama', 'tanggal_mulai' => "$year-$month-04", 'kategori' => 'Kegiatan Sekolah', 'deskripsi' => 'Kegiatan rutin makan sehat bersama.'],
            ['judul' => 'Visit Perpustakaan', 'tanggal_mulai' => "$year-$month-05", 'kategori' => 'Kegiatan Sekolah', 'deskripsi' => 'Kunjungan ke perpustakaan daerah.'],
            ['judul' => 'Evaluasi Kognitif', 'tanggal_mulai' => "$year-$month-10", 'kategori' => 'Ujian', 'deskripsi' => 'Penilaian perkembangan kognitif anak.'],
            ['judul' => 'Libur Mid-Term', 'tanggal_mulai' => "$year-$month-23", 'tanggal_selesai' => "$year-$month-25", 'kategori' => 'Libur Nasional', 'deskripsi' => 'Libur pertengahan semester.'],
        ];

        foreach ($events as $event) {
            KalenderAkademik::updateOrCreate(
                ['judul' => $event['judul'], 'tanggal_mulai' => $event['tanggal_mulai']],
                $event
            );
        }
    }
}
