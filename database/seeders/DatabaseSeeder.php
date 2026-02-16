<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.dev',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Sekolah No. 1',
            'email_verified_at' => now(),
        ]);

        // Buat Kepala Sekolah
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@sekolah.dev',
            'password' => Hash::make('password123'),
            'role' => 'kepala_sekolah',
            'jenis_kelamin' => 'Laki-laki',
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Sekolah No. 2',
            'email_verified_at' => now(),
        ]);

        // Buat Operator
        User::create([
            'name' => 'Operator Sekolah',
            'email' => 'operator@sekolah.dev',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'jenis_kelamin' => 'Perempuan',
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Operator No. 1',
            'email_verified_at' => now(),
        ]);

        // Buat beberapa Guru (user biasa, bukan dari tabel guru)
        $guruList = [
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@sekolah.dev',
                'jk' => 'Laki-laki',
                'no_telp' => '081234567893',
            ],
            [
                'name' => 'Siti Aminah, S.Pd',
                'email' => 'siti.aminah@sekolah.dev',
                'jk' => 'Perempuan',
                'no_telp' => '081234567894',
            ],
            [
                'name' => 'Ahmad Fauzi, M.Pd',
                'email' => 'ahmad.fauzi@sekolah.dev',
                'jk' => 'Laki-laki',
                'no_telp' => '081234567895',
            ],
        ];

        foreach ($guruList as $guru) {
            User::create([
                'name' => $guru['name'],
                'email' => $guru['email'],
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'jenis_kelamin' => $guru['jk'],
                'no_telepon' => $guru['no_telp'],
                'alamat' => 'Jl. Guru No. ' . rand(1, 10),
                'email_verified_at' => now(),
            ]);
        }

        // Panggil seeder lain (TANPA GuruSeeder)
        $this->call([
            TahunAjaranSeeder::class,
            SiswaSeeder::class,
            SpmbSeeder::class,
        ]);

        // Tampilkan info
        $this->command->info('=================================');
        $this->command->info('DATABASE SEEDING BERHASIL!');
        $this->command->info('=================================');
        $this->command->info('Admin      : admin@sekolah.dev');
        $this->command->info('Kepsek     : kepsek@sekolah.dev'); 
        $this->command->info('Operator   : operator@sekolah.dev');
        $this->command->info('Guru       : budi.santoso@sekolah.dev (dan lainnya)');
        $this->command->info('Password   : password123 (semua akun)');
        $this->command->info('=================================');
    }
}