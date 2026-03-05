<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SpmbSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $ta = TahunAjaran::where('is_aktif', true)->first() ?? TahunAjaran::first();
        $admin = User::where('role', 'admin')->first() ?? User::first();
        
        $statusOptions = ['Menunggu Verifikasi', 'Diterima', 'Ditolak', 'Revisi Dokumen'];
        
        $tinggalBersamaOptions = ['Ayah dan Ibu', 'Keluarga Ayah', 'Keluarga Ibu', 'Lainnya'];
        $statusTempatTinggalOptions = ['Milik Sendiri', 'Milik Keluarga', 'Kontrakan'];
        $pekerjaanAyahOptions = ['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'];
        $pekerjaanIbuOptions = ['Ibu Rumah Tangga', 'Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'];

        for ($i = 1; $i <= 30; $i++) {
            $jk = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $status = $faker->randomElement($statusOptions);
            $isDiterima = ($status === 'Diterima');
            $tahunSekarang = date('Y');

            DB::table('spmb')->insert([
                'no_pendaftaran' => 'REG-' . $tahunSekarang . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tahun_ajaran_id' => $ta->id,
                'status_pendaftaran' => $status,
                
                'nama_lengkap_anak' => $faker->name($jk == 'Laki-laki' ? 'male' : 'female'),
                'nama_panggilan_anak' => $faker->firstName(),
                'nik_anak' => $faker->nik(),
                'tempat_lahir_anak' => $faker->city(),
                'tanggal_lahir_anak' => $faker->date('Y-m-d', '-5 years'),
                
                'provinsi_rumah' => 'Jawa Barat',
                'kota_kabupaten_rumah' => 'Bandung',
                'kecamatan_rumah' => $faker->streetName(),
                'kelurahan_rumah' => $faker->streetName(),
                'nama_jalan_rumah' => $faker->streetAddress(),
                'alamat_kk_sama' => true,

                'jenis_kelamin' => $jk,
                'agama' => $faker->randomElement(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha']),
                'anak_ke' => $faker->numberBetween(1, 3),
                'tinggal_bersama' => $faker->randomElement($tinggalBersamaOptions),
                'status_tempat_tinggal' => $faker->randomElement($statusTempatTinggalOptions),
                'bahasa_sehari_hari' => $faker->randomElement(['Indonesia', 'Sunda', 'Jawa']),
                'jarak_rumah_ke_sekolah' => $faker->numberBetween(500, 5000),
                'waktu_tempuh_ke_sekolah' => $faker->numberBetween(10, 30),
                'berat_badan' => $faker->randomFloat(2, 15, 25),
                'tinggi_badan' => $faker->randomFloat(2, 90, 115),
                'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O', 'Tidak Tahu']),
                
                'nama_lengkap_ayah' => $faker->name('male'),
                'nik_ayah' => $faker->nik(),
                'tempat_lahir_ayah' => $faker->city(),
                'tanggal_lahir_ayah' => $faker->date('Y-m-d', '-35 years'),
                'pendidikan_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D1-D3', 'S1', 'S2']),
                'pekerjaan_ayah' => $faker->randomElement($pekerjaanAyahOptions),
                'penghasilan_per_bulan_ayah' => $faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta']),
                'nomor_telepon_ayah' => '08' . $faker->numerify('##########'),
                
                'nama_lengkap_ibu' => $faker->name('female'),
                'nik_ibu' => $faker->nik(),
                'tempat_lahir_ibu' => $faker->city(),
                'tanggal_lahir_ibu' => $faker->date('Y-m-d', '-30 years'),
                'pendidikan_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D1-D3', 'S1', 'S2']),
                'pekerjaan_ibu' => $faker->randomElement($pekerjaanIbuOptions),
                'penghasilan_per_bulan_ibu' => $faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta']),
                'nomor_telepon_ibu' => '08' . $faker->numerify('##########'),

                'sumber_informasi_ppdb' => $faker->randomElement(['Media Sosial', 'Website Sekolah', 'Spanduk/Baliho', 'Teman/Keluarga', 'Guru', 'Lainnya']),
                'punya_saudara_sekolah_tk' => $faker->randomElement(['Ya', 'Tidak']),
                'jenis_daftar' => 'Siswa Baru',

                'verifikasi_akte' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_kk' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_ktp' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_bukti_transfer' => $isDiterima ? 1 : $faker->boolean(20),
                'diverifikasi_oleh' => $isDiterima ? $admin->id : ($faker->boolean(30) ? $admin->id : null),
                'tanggal_verifikasi_akte' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_kk' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_ktp' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_bukti_transfer' => $isDiterima ? now()->subDays(rand(1, 5)) : null,

                'approved_by_kepsek' => $isDiterima ? 1 : 0,
                'kepsek_id' => $isDiterima ? $admin->id : null,
                'tanggal_approval' => $isDiterima ? now()->subDays(rand(1, 3)) : null,

                'kelas' => $isDiterima ? $faker->randomElement(['Kelompok A', 'Kelompok B']) : null,
                'guru_kelas' => $isDiterima ? 'Bu ' . $faker->name('female') : null,
                'is_aktif' => 1,
                'nomor_induk_siswa' => $isDiterima ? $faker->unique()->numerify('NIS-' . $tahunSekarang . '-#####') : null,
                'is_lulus' => 0,
                'is_mengulang' => 0,

                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}
