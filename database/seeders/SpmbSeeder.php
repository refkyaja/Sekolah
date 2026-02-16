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

        // Buat 30 data pendaftar
        for ($i = 1; $i <= 30; $i++) {
            $jk = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $status = $faker->randomElement(['Diterima', 'Menunggu Verifikasi', 'Mundur']);
            $isDiterima = ($status === 'Diterima');

            // Opsi untuk field-field yang diubah
            $tinggalBersamaOptions = ['Ayah dan Ibu', 'Keluarga Ayah', 'Keluarga Ibu', 'Lainnya'];
            $statusTempatTinggalOptions = ['Milik Sendiri', 'Milik Keluarga', 'Kontrakan'];
            $pekerjaanAyahOptions = ['Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'];
            $pekerjaanIbuOptions = ['Ibu Rumah Tangga', 'Pekerja Informal', 'Wirausaha', 'Pegawai Swasta', 'PNS'];
            $punyaSaudaraOptions = ['Ya', 'Tidak'];

            // Tentukan apakah punya wali (30% kemungkinan)
            $punyaWali = $faker->boolean(30);

            // Set nilai field wali berdasarkan $punyaWali
            $namaLengkapWali = $punyaWali ? $faker->name() : null;
            $hubunganDenganAnak = $punyaWali ? $faker->randomElement(['Kakek', 'Nenek', 'Paman', 'Bibi']) : null;
            $nikWali = $punyaWali ? $faker->nik() : null;
            $tempatLahirWali = $punyaWali ? $faker->city() : null;
            $tanggalLahirWali = $punyaWali ? $faker->date('Y-m-d', '-40 years') : null;
            $pendidikanWali = $punyaWali ? $faker->randomElement(['SD', 'SMP', 'SMA', 'D1-D3', 'S1', 'S2']) : null;
            $pekerjaanWali = $punyaWali ? $faker->jobTitle() : null;
            $bidangPekerjaanWali = $punyaWali ? $faker->optional()->jobTitle() : null;
            $penghasilanWali = $punyaWali ? $faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta']) : null;
            $nomorTeleponWali = $punyaWali ? '08' . $faker->numerify('##########') : null;
            $emailWali = $punyaWali ? $faker->email() : null;

            DB::table('spmb')->insert([
                'no_pendaftaran' => 'REG-' . now()->year . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tahun_ajaran_id' => $ta->id,
                'status_pendaftaran' => $status,
                
                // Data Anak
                'nama_lengkap_anak' => $faker->name($jk == 'Laki-laki' ? 'male' : 'female'),
                'nama_panggilan_anak' => $faker->firstName(),
                'nik_anak' => $faker->nik(),
                'tempat_lahir_anak' => $faker->city(),
                'tanggal_lahir_anak' => $faker->date('Y-m-d', '-5 years'),
                
                // Alamat
                'provinsi_rumah' => 'Jawa Barat',
                'kota_kabupaten_rumah' => 'Bandung',
                'kecamatan_rumah' => $faker->streetName(),
                'kelurahan_rumah' => $faker->streetName(),
                'nama_jalan_rumah' => $faker->streetAddress(),
                'alamat_kk_sama' => true,
                'provinsi_kk' => null,
                'kota_kabupaten_kk' => null,
                'kecamatan_kk' => null,
                'kelurahan_kk' => null,
                'nama_jalan_kk' => null,
                'alamat_kk' => null,

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
                'penyakit_pernah_diderita' => $faker->optional(0.7)->randomElement(['Demam Berdarah', 'Cacar', 'Asma', 'Bronkitis']),
                'imunisasi_pernah_diterima' => $faker->optional(0.8)->sentence(3),
                
                // Data Ayah
                'nama_lengkap_ayah' => $faker->name('male'),
                'nik_ayah' => $faker->nik(),
                'tempat_lahir_ayah' => $faker->city(),
                'tanggal_lahir_ayah' => $faker->date('Y-m-d', '-35 years'),
                'alamat_ayah' => null,
                'provinsi_ayah' => null,
                'kota_kabupaten_ayah' => null,
                'kecamatan_ayah' => null,
                'kelurahan_ayah' => null,
                'nama_jalan_ayah' => null,
                'pendidikan_ayah' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D1-D3', 'S1', 'S2']),
                'pekerjaan_ayah' => $faker->randomElement($pekerjaanAyahOptions),
                'bidang_pekerjaan_ayah' => $faker->optional(0.8)->jobTitle(),
                'penghasilan_per_bulan_ayah' => $faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta']),
                'nomor_telepon_ayah' => '08' . $faker->numerify('##########'),
                'email_ayah' => $faker->optional(0.6)->email(),
                
                // Data Ibu
                'nama_lengkap_ibu' => $faker->name('female'),
                'nik_ibu' => $faker->nik(),
                'tempat_lahir_ibu' => $faker->city(),
                'tanggal_lahir_ibu' => $faker->date('Y-m-d', '-30 years'),
                'alamat_ibu' => null,
                'provinsi_ibu' => null,
                'kota_kabupaten_ibu' => null,
                'kecamatan_ibu' => null,
                'kelurahan_ibu' => null,
                'nama_jalan_ibu' => null,
                'pendidikan_ibu' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D1-D3', 'S1', 'S2']),
                'pekerjaan_ibu' => $faker->randomElement($pekerjaanIbuOptions),
                'bidang_pekerjaan_ibu' => $faker->optional(0.8)->jobTitle(),
                'penghasilan_per_bulan_ibu' => $faker->randomElement(['< 1 juta', '1-3 juta', '3-5 juta', '5-10 juta', '> 10 juta']),
                'nomor_telepon_ibu' => '08' . $faker->numerify('##########'),
                'email_ibu' => $faker->optional(0.6)->email(),

                // Data Wali (nilai sudah ditentukan di atas)
                'punya_wali' => $punyaWali,
                'nama_lengkap_wali' => $namaLengkapWali,
                'hubungan_dengan_anak' => $hubunganDenganAnak,
                'nik_wali' => $nikWali,
                'tempat_lahir_wali' => $tempatLahirWali,
                'tanggal_lahir_wali' => $tanggalLahirWali,
                'alamat_wali' => null,
                'provinsi_wali' => null,
                'kota_kabupaten_wali' => null,
                'kecamatan_wali' => null,
                'kelurahan_wali' => null,
                'nama_jalan_wali' => null,
                'pendidikan_wali' => $pendidikanWali,
                'pekerjaan_wali' => $pekerjaanWali,
                'bidang_pekerjaan_wali' => $bidangPekerjaanWali,
                'penghasilan_per_bulan_wali' => $penghasilanWali,
                'nomor_telepon_wali' => $nomorTeleponWali,
                'email_wali' => $emailWali,

                // Informasi Tambahan
                'sumber_informasi_ppdb' => $faker->randomElement(['Media Sosial', 'Website Sekolah', 'Spanduk/Baliho', 'Teman/Keluarga', 'Guru', 'Lainnya']),
                'punya_saudara_sekolah_tk' => $faker->randomElement($punyaSaudaraOptions),
                'jenis_daftar' => $faker->randomElement(['Siswa Baru', 'Pindahan']),

                // Verifikasi (Jika diterima, maka otomatis terverifikasi)
                'verifikasi_akte' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_kk' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_ktp' => $isDiterima ? 1 : $faker->boolean(30),
                'verifikasi_bukti_transfer' => $isDiterima ? 1 : $faker->boolean(20),
                'diverifikasi_oleh' => $isDiterima ? $admin->id : ($faker->boolean(30) ? $admin->id : null),
                'tanggal_verifikasi_akte' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_kk' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_ktp' => $isDiterima ? now()->subDays(rand(1, 10)) : null,
                'tanggal_verifikasi_bukti_transfer' => $isDiterima ? now()->subDays(rand(1, 5)) : null,

                // Approval Kepsek
                'approved_by_kepsek' => $isDiterima ? 1 : 0,
                'kepsek_id' => $isDiterima ? $admin->id : null,
                'tanggal_approval' => $isDiterima ? now()->subDays(rand(1, 3)) : null,

                // Data Kelas (Hanya diisi jika diterima)
                'kelas' => $isDiterima ? $faker->randomElement(['Kelompok A', 'Kelompok B']) : null,
                'guru_kelas' => $isDiterima ? 'Bu ' . $faker->name('female') : null,
                'operator_input_kelas' => $isDiterima ? $admin->id : null,
                'is_aktif' => $isDiterima ? 1 : 0,
                'nomor_induk_siswa' => $isDiterima ? $faker->unique()->numerify('NIS-' . now()->year . '-#####') : null,
                'is_lulus' => 0,
                'is_mengulang' => 0,

                'catatan_admin' => $faker->optional(0.3)->sentence(),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}