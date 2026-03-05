<?php

namespace Database\Seeders;

use App\Models\Spmb;
use App\Models\SpmbDokumen;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class SpmbSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::where('is_aktif', true)->first();

        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::first();
        }

        $namaLaki = [
            'Ahmad Fauzi', 'Muhammad Rizky', 'Farhan Akbar', 'Daffa Rahmat', 'Alvaro Putra',
            'Kayla Aziz', 'Rafi Pratama', 'Zacky Zidane', 'Fajar Nugroho', 'Hafiz Quran',
            'Abi Wiranata', 'Danish Haikal', 'Evan Maximillian', 'Gilang Ramadan', 'Indra Permana'
        ];

        $namaPerempuan = [
            'Siti Nurhaliza', 'Putri Ayu Lestari', 'Nadira Zahra', 'Alya Safitri', 'Dewi Sartika',
            'Nurul Hidayah', 'Salsa Julia', 'Tika Amelia', 'Aini Qonita', 'Maya Sari'
        ];

        $tempatLahir = ['Jakarta', 'Depok', 'Bekasi', 'Tangerang', 'Bogor', 'Bandung'];
        $provinsi = ['DKI Jakarta', 'Jawa Barat', 'Banten'];
        $agama = ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha'];
        $jk = ['Laki-laki', 'Perempuan'];

        $data = [];
        $no = 1;

        for ($i = 0; $i < 25; $i++) {
            $isLaki = $i < 12;
            $nama = $isLaki ? $namaLaki[$i % count($namaLaki)] : $namaPerempuan[$i % count($namaPerempuan)];
            $jenisKelamin = $isLaki ? 'Laki-laki' : 'Perempuan';
            $jkDb = $isLaki ? 'L' : 'P';

            $bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $tanggal = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
            $tanggalLahir = "2020-{$bulan}-{$tanggal}";

            $tahunLahirCarbon = \Carbon\Carbon::parse($tanggalLahir);
            $usia = $tahunLahirCarbon->age;

            $status = $i < 5 ? 'Lulus' : ($i < 10 ? 'Dokumen Verified' : ($i < 15 ? 'Menunggu Verifikasi' : 'Revisi Dokumen'));

            $data[] = [
                'no_pendaftaran' => 'PPDB/' . date('Y') . '/' . str_pad($no++, 4, '0', STR_PAD_LEFT),
                'tahun_ajaran_id' => $tahunAjaran->id,
                'status_pendaftaran' => $status,
                'nama_lengkap_anak' => $nama,
                'nama_panggilan_anak' => explode(' ', $nama)[0],
                'nik_anak' => '3175' . str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT),
                'tempat_lahir_anak' => $tempatLahir[array_rand($tempatLahir)],
                'tanggal_lahir_anak' => $tanggalLahir,
                'provinsi_rumah' => $provinsi[array_rand($provinsi)],
                'kota_kabupaten_rumah' => 'Jakarta Selatan',
                'kecamatan_rumah' => 'Kebayoran Baru',
                'kelurahan_rumah' => 'Cipete Utara',
                'nama_jalan_rumah' => 'Jl. Raya Cipete No. ' . rand(1, 100),
                'alamat_kk_sama' => true,
                'jenis_kelamin' => $jenisKelamin,
                'agama' => $agama[array_rand($agama)],
                'anak_ke' => rand(1, 3),
                'tinggal_bersama' => 'Ayah dan Ibu',
                'status_tempat_tinggal' => 'Milik Sendiri',
                'bahasa_sehari_hari' => 'Indonesia',
                'jarak_rumah_ke_sekolah' => rand(500, 5000),
                'waktu_tempuh_ke_sekolah' => rand(10, 60),
                'berat_badan' => rand(15, 25),
                'tinggi_badan' => rand(100, 120),
                'golongan_darah' => ['A', 'B', 'AB', 'O'][array_rand(['A', 'B', 'AB', 'O'])],
                'nama_lengkap_ayah' => 'Bpk. ' . explode(' ', $nama)[0] . ' Setiawan',
                'nik_ayah' => '3175' . str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT),
                'tempat_lahir_ayah' => $tempatLahir[array_rand($tempatLahir)],
                'tanggal_lahir_ayah' => '1985-01-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'pendidikan_ayah' => ['S1', 'S2', 'SMA', 'SMK'][array_rand(['S1', 'S2', 'SMA', 'SMK'])],
                'pekerjaan_ayah' => ['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'][array_rand(['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'])],
                'penghasilan_per_bulan_ayah' => ['Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', 'Rp 5.000.000 - Rp 10.000.000'][rand(0, 2)],
                'nomor_telepon_ayah' => '081' . rand(100000000, 999999999),
                'email_ayah' => 'ayah.' . strtolower(explode(' ', $nama)[0]) . '@email.com',
                'nama_lengkap_ibu' => 'Ibu. ' . explode(' ', $nama)[0] . ' Dewi',
                'nik_ibu' => '3175' . str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT),
                'tempat_lahir_ibu' => $tempatLahir[array_rand($tempatLahir)],
                'tanggal_lahir_ibu' => '1987-01-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'pendidikan_ibu' => ['S1', 'S2', 'SMA', 'SMK'][array_rand(['S1', 'S2', 'SMA', 'SMK'])],
                'pekerjaan_ibu' => ['Ibu Rumah Tangga', 'Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'][rand(0, 4)],
                'penghasilan_per_bulan_ibu' => ['Rp 1.000.000 - Rp 3.000.000', 'Rp 3.000.000 - Rp 5.000.000', 'Rp 5.000.000 - Rp 10.000.000'][rand(0, 2)],
                'nomor_telepon_ibu' => '081' . rand(100000000, 999999999),
                'email_ibu' => 'ibu.' . strtolower(explode(' ', $nama)[0]) . '@email.com',
                'sumber_informasi_ppdb' => ['Instagram', 'Facebook', 'Teman', 'Sorwar', 'Banner'][rand(0, 4)],
                'punya_saudara_sekolah_tk' => rand(0, 1) ? 'Ya' : 'Tidak',
                'jenis_daftar' => 'Siswa Baru',
                'verifikasi_akte' => in_array($status, ['Lulus', 'Dokumen Verified']) ? true : false,
                'verifikasi_kk' => in_array($status, ['Lulus', 'Dokumen Verified']) ? true : false,
                'verifikasi_ktp' => in_array($status, ['Lulus', 'Dokumen Verified']) ? true : false,
                'verifikasi_bukti_transfer' => in_array($status, ['Lulus', 'Dokumen Verified']) ? true : false,
                'tanggal_verifikasi_akte' => in_array($status, ['Lulus', 'Dokumen Verified']) ? now() : null,
                'tanggal_verifikasi_kk' => in_array($status, ['Lulus', 'Dokumen Verified']) ? now() : null,
                'tanggal_verifikasi_ktp' => in_array($status, ['Lulus', 'Dokumen Verified']) ? now() : null,
                'tanggal_verifikasi_bukti_transfer' => in_array($status, ['Lulus', 'Dokumen Verified']) ? now() : null,
            ];
        }

        foreach ($data as $item) {
            $spmb = Spmb::firstOrCreate(
                ['no_pendaftaran' => $item['no_pendaftaran']],
                $item
            );

            // Buat dokumen seolah-olah sudah diupload
            $jenisDokumen = ['akte', 'kk', 'ktp'];
            foreach ($jenisDokumen as $jenis) {
                SpmbDokumen::firstOrCreate(
                    [
                        'spmb_id' => $spmb->id,
                        'jenis_dokumen' => $jenis
                    ],
                    [
                        'nama_file' => $jenis . '_' . $spmb->no_pendaftaran . '.pdf',
                        'path_file' => 'dokumen/' . $spmb->no_pendaftaran . '/' . $jenis . '.pdf',
                        'mime_type' => 'application/pdf',
                        'ukuran_file' => rand(100, 500),
                    ]
                );
            }
        }
    }
}
