<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita; // Pastikan model Berita sudah dibuat

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 berita terbaru dari database
        $berita = Berita::latest()->take(3)->get();
        
        // Data dummy untuk preview jika belum ada berita
        if ($berita->isEmpty()) {
            $berita = [
                (object) [
                    'id' => 1,
                    'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2024/2025',
                    'isi' => 'Pendaftaran siswa baru TK Ceria Bangsa telah dibuka. Daftarkan putra-putri Anda sekarang juga!',
                    'gambar' => 'images/default-news.jpg',
                    'created_at' => now(),
                ],
                (object) [
                    'id' => 2,
                    'judul' => 'Workshop Parenting: Mendidik Anak di Era Digital',
                    'isi' => 'Sekolah mengadakan workshop parenting untuk orang tua siswa dengan tema pendidikan anak di era digital.',
                    'gambar' => 'images/default-news.jpg',
                    'created_at' => now()->subDays(2),
                ],
                (object) [
                    'id' => 3,
                    'judul' => 'Field Trip Edukatif ke Kebun Binatang',
                    'isi' => 'Siswa-siswi TK Ceria Bangsa mengunjungi kebun binatang untuk belajar langsung tentang hewan.',
                    'gambar' => 'images/default-news.jpg',
                    'created_at' => now()->subDays(5),
                ],
            ];
        }

        // Data guru
        $guru = [
            [
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jabatan' => 'Kepala Sekolah',
                'deskripsi' => 'S1 Pendidikan Anak Usia Dini, 15 tahun pengalaman',
                'foto' => 'images/kepala-sekolah.jpg'
            ],
            [
                'nama' => 'Ahmad Rizki, S.Pd',
                'jabatan' => 'Guru Kelompok A',
                'deskripsi' => 'S1 Pendidikan Guru PAUD, spesialis anak usia 4-5 tahun',
                'foto' => 'images/guru1.jpg'
            ],
            [
                'nama' => 'Maya Sari, S.Pd',
                'jabatan' => 'Guru Kelompok B',
                'deskripsi' => 'S1 Psikologi Pendidikan, ahli perkembangan anak',
                'foto' => 'images/guru2.jpg'
            ],
            [
                'nama' => 'Rina Permata, S.Pd.AUD',
                'jabatan' => 'Guru Bimbingan Konseling',
                'deskripsi' => 'S1 Pendidikan Anak Usia Dini, ahli psikologi anak',
                'foto' => 'images/guru3.jpg'
            ],
        ];

        // Data kegiatan
        $kegiatan = [
            [
                'judul' => 'Field Trip ke Kebun Binatang',
                'tanggal' => '15 Maret 2024',
                'deskripsi' => 'Anak-anak belajar mengenal berbagai jenis hewan',
                'foto' => 'images/kegiatan1.jpg'
            ],
            [
                'judul' => 'Pentas Seni Akhir Tahun',
                'tanggal' => '20 Juni 2024',
                'deskripsi' => 'Pertunjukan bakat dan kreativitas anak-anak',
                'foto' => 'images/kegiatan2.jpg'
            ],
        ];

        return view('home', compact('berita', 'guru', 'kegiatan'));
    }
}