<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::where('is_aktif', true)->first();

        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::first();
        }

        $data = [
            [
                'nik' => '3175010101010001',
                'nama_lengkap' => 'Ahmad Fauzi',
                'nama_panggilan' => 'Fauzi',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2019-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 10, RT 001 RW 001, Kelurahan Menteng, Kecamatan Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'kota_kabupaten' => 'Jakarta Pusat',
                'kecamatan' => 'Menteng',
                'kelurahan' => 'Menteng',
                'nama_jalan' => 'Jl. Merdeka No. 10',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Aminah',
                'no_hp_ortu' => '081234567890',
                'email_ortu' => 'budi.santoso@email.com',
                'kelompok' => 'B',
                'kelas' => 'B1',
                'jalur_masuk' => 'Zonasi',
                'tanggal_masuk' => '2025-07-14',
            ],
            [
                'nik' => '3175010101010002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'nama_panggilan' => 'Siti',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2019-08-22',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 25, RT 002 RW 003, Kelurahan Senayan, Kecamatan Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kota_kabupaten' => 'Jakarta Selatan',
                'kecamatan' => 'Senayan',
                'kelurahan' => 'Senayan',
                'nama_jalan' => 'Jl. Sudirman No. 25',
                'nama_ayah' => 'Hendra Wijaya',
                'nama_ibu' => 'Dewi Lestari',
                'no_hp_ortu' => '081234567891',
                'email_ortu' => 'hendra.wijaya@email.com',
                'kelompok' => 'B',
                'kelas' => 'B1',
                'jalur_masuk' => 'Zonasi',
                'tanggal_masuk' => '2025-07-14',
            ],
            [
                'nik' => '3175010101010003',
                'nama_lengkap' => 'Muhammad Rizky',
                'nama_panggilan' => 'Rizky',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2019-03-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Thamrin No. 50, RT 003 RW 005, Kelurahan Menteng, Kecamatan Jakarta Pusat',
                'provinsi' => 'DKI Jakarta',
                'kota_kabupaten' => 'Jakarta Pusat',
                'kecamatan' => 'Menteng',
                'kelurahan' => 'Menteng',
                'nama_jalan' => 'Jl. Thamrin No. 50',
                'nama_ayah' => 'Ahmad Kurniawan',
                'nama_ibu' => 'Kartika Sari',
                'no_hp_ortu' => '081234567892',
                'email_ortu' => 'ahmad.kurniawan@email.com',
                'kelompok' => 'B',
                'kelas' => 'B2',
                'jalur_masuk' => 'Prestasi',
                'tanggal_masuk' => '2025-07-14',
            ],
            [
                'nik' => '3175010101010004',
                'nama_lengkap' => 'Putri Ayu Lestari',
                'nama_panggilan' => 'Putri',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2019-11-05',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Gatot Subroto No. 30, RT 004 RW 002, Kelurahan Mampang Prapatan, Kecamatan Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kota_kabupaten' => 'Jakarta Selatan',
                'kecamatan' => 'Mampang Prapatan',
                'kelurahan' => 'Mampang Prapatan',
                'nama_jalan' => 'Jl. Gatot Subroto No. 30',
                'nama_ayah' => 'Dedi Hermawan',
                'nama_ibu' => 'Sri Wahyuni',
                'no_hp_ortu' => '081234567893',
                'email_ortu' => 'dedi.hermawan@email.com',
                'kelompok' => 'B',
                'kelas' => 'B2',
                'jalur_masuk' => 'Zonasi',
                'tanggal_masuk' => '2025-07-14',
            ],
            [
                'nik' => '3175010101010005',
                'nama_lengkap' => 'Farhan Akbar',
                'nama_panggilan' => 'Farhan',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2019-06-20',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. HR Rasuna Said No. 15, RT 005 RW 001, Kelurahan Karet, Kecamatan Jakarta Selatan',
                'provinsi' => 'DKI Jakarta',
                'kota_kabupaten' => 'Jakarta Selatan',
                'kecamatan' => 'Karet',
                'kelurahan' => 'Karet',
                'nama_jalan' => 'Jl. HR Rasuna Said No. 15',
                'nama_ayah' => 'Rizki Akbar',
                'nama_ibu' => 'Nurul Hidayah',
                'no_hp_ortu' => '081234567894',
                'email_ortu' => 'rizki.akbar@email.com',
                'kelompok' => 'B',
                'kelas' => 'B1',
                'jalur_masuk' => 'Afirmasi',
                'tanggal_masuk' => '2025-07-14',
            ],
        ];

        foreach ($data as $siswa) {
            $password = strtolower(str_replace(' ', '', $siswa['nama_lengkap'])) . '123';
            
            $siswa['nis'] = '2025' . str_pad(Siswa::count() + 1, 4, '0', STR_PAD_LEFT);
            $siswa['nisn'] = '001' . str_pad(Siswa::count() + 1, 10, '0', STR_PAD_LEFT);
            $siswa['username'] = strtolower(str_replace(' ', '', $siswa['nama_lengkap']));
            $siswa['email'] = strtolower(str_replace(' ', '', $siswa['nama_lengkap'])) . '@siswa.sch.id';
            $siswa['password'] = Hash::make($password);
            $siswa['tahun_ajaran_id'] = $tahunAjaran->id;
            $siswa['tahun_ajaran'] = $tahunAjaran->tahun_ajaran;
            $siswa['status_siswa'] = 'aktif';

            Siswa::firstOrCreate(
                ['nik' => $siswa['nik']],
                $siswa
            );
        }
    }
}
