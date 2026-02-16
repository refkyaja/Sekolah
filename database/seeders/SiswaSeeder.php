<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil tahun ajaran yang sedang aktif
        $ta = TahunAjaran::where('is_aktif', true)->first() ?? TahunAjaran::first();

        for ($i = 1; $i <= 20; $i++) {
            $jk = $faker->randomElement(['L', 'P']);
            $nama = $faker->name($jk == 'L' ? 'male' : 'female');

            Siswa::create([
                'nis' => '2025' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nisn' => '00' . $faker->numerify('########'),
                'nik' => $faker->nik(),
                'nama_lengkap' => $nama,
                'nama_panggilan' => explode(' ', $nama)[0],
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->date('Y-m-d', '-5 years'),
                'jenis_kelamin' => $jk,
                'agama' => 'Islam',
                'alamat' => $faker->address(),
                'provinsi' => 'Jawa Barat',
                'kota_kabupaten' => 'Bandung',
                'kecamatan' => 'Cicendo',
                'kelurahan' => 'Pasirkaliki',
                'nama_jalan' => $faker->streetAddress(),
                'nama_ayah' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),
                'no_hp_ortu' => '08' . $faker->numerify('##########'),
                'kelompok' => $faker->randomElement(['A', 'B']),
                'tahun_ajaran_id' => $ta->id,
                'tahun_ajaran' => $ta->tahun_ajaran, // untuk kolom kompatibilitas
                'status_siswa' => 'aktif',
                'tanggal_masuk' => $ta->tanggal_mulai,
                'kelas' => 'Bintang Kecil',
            ]);
        }
    }
}