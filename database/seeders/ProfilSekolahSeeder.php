<?php

namespace Database\Seeders;

use App\Models\ProfilSekolah;
use Illuminate\Database\Seeder;

class ProfilSekolahSeeder extends Seeder
{
    public function run(): void
    {
        ProfilSekolah::create([
            'sambutan_judul' => 'Membangun Masa Depan Melalui Karakter',
            'sambutan_teks' => 'Selamat datang di TK HARAPAN BANGSA 1. Kami percaya bahwa pendidikan bukan hanya tentang transfer ilmu pengetahuan, tetapi juga pembentukan integritas. Di sini, kami berkomitmen untuk menyediakan lingkungan yang aman dan inspiratif bagi setiap siswa untuk mengeksplorasi potensi terbaik mereka.',
            'kepsek_nama' => 'Dr. Irwan Santoso, M.Pd',
            'visi' => 'Menjadi lembaga pendidikan terdepan yang menghasilkan lulusan unggul dalam prestasi, berkarakter luhur, dan siap bersaing di kancah global berdasarkan nilai-nilai kemanusiaan.',
            'misi' => [
                'Menyelenggarakan pembelajaran berbasis teknologi dan inovasi.',
                'Mengembangkan lingkungan belajar yang inklusif dan kolaboratif.',
                'Menanamkan nilai-nilai etika dan tanggung jawab sosial pada siswa.'
            ],
            'sejarah' => 'Didirikan pada tahun 1995, Vidya Mandir (kini TK HARAPAN BANGSA 1) berawal dari sebuah visi sederhana untuk memberikan akses pendidikan berkualitas bagi masyarakat sekitar. Selama lebih dari dua dekade, sekolah ini telah berkembang dari satu gedung kecil menjadi kompleks pendidikan modern yang lengkap.',
            'npsn' => '20104567',
            'status_akreditasi' => 'Swasta (Akreditasi A)',
            'alamat' => 'Jl. Pendidikan No. 45, Kebayoran Baru, Jakarta Selatan',
            'kurikulum' => 'Kurikulum Merdeka',
            'telepon' => '(021) 1234-5678',
            'email' => 'info@harapanbangsa1.sch.id',
        ]);
    }
}
