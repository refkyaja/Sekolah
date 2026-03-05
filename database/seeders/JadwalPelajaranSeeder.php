<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JadwalPelajaran;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil tahun ajaran aktif
        $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::first();

        if (!$ta) return;

        $data = [
            // Kelompok A - Senin
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Senin', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00', 'mata_pelajaran' => 'Matematika', 'kategori' => 'akademik', 'guru' => 'Budi Santoso, M.Pd'],
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Senin', 'jam_mulai' => '09:00', 'jam_selesai' => '10:30', 'mata_pelajaran' => 'Bahasa Indonesia', 'kategori' => 'akademik', 'guru' => 'Siti Aminah, S.Pd'],
            
            // Selasa
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Selasa', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00', 'mata_pelajaran' => 'IPA', 'kategori' => 'akademik', 'guru' => 'Dr. Ahmad Yani'],
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Selasa', 'jam_mulai' => '09:00', 'jam_selesai' => '10:30', 'mata_pelajaran' => 'Bahasa Inggris', 'kategori' => 'akademik', 'guru' => 'Jessica Brown, M.A'],
            
            // Rabu
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Rabu', 'jam_mulai' => '07:30', 'jam_selesai' => '09:00', 'mata_pelajaran' => 'Seni Budaya', 'kategori' => 'art', 'guru' => 'Rangga Widjaya, S.Sn'],
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Rabu', 'jam_mulai' => '09:00', 'jam_selesai' => '10:30', 'mata_pelajaran' => 'Pendidikan Agama', 'kategori' => 'akademik', 'guru' => 'Ust. Mansur Halim'],
            
            // Kamis
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Kamis', 'jam_mulai' => '07:30', 'jam_selesai' => '09:30', 'mata_pelajaran' => 'Olahraga', 'kategori' => 'physical', 'guru' => 'Anton Kusuma, S.Pd'],
            
            // Jumat
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Jumat', 'jam_mulai' => '07:30', 'jam_selesai' => '08:30', 'mata_pelajaran' => 'Pramuka', 'kategori' => 'special', 'guru' => 'Pembina Pramuka'],
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'A', 'hari' => 'Jumat', 'jam_mulai' => '08:30', 'jam_selesai' => '10:00', 'mata_pelajaran' => 'Kewirausahaan', 'kategori' => 'akademik', 'guru' => 'Indah Permata, SE'],

            // Kelompok B (Sample)
            ['tahun_ajaran_id' => $ta->id, 'semester' => $ta->semester, 'kelompok' => 'B', 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '09:30', 'mata_pelajaran' => 'Robotik Dasar', 'kategori' => 'akademik', 'guru' => 'Engkus Kusnadi'],
        ];

        foreach ($data as $d) {
            JadwalPelajaran::create($d);
        }
    }
}
