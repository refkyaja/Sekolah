<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil berita terbaru untuk ditampilkan di homepage (max 3)
        $beritas = Berita::where('status', 'publish')
                        ->where('tanggal_publish', '<=', now())
                        ->orderBy('tanggal_publish', 'desc')
                        ->take(3)
                        ->get();
        
        // Ambil data galeri - TAMBAHKAN INI!
        $galeris = Galeri::where('is_published', 1)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->take(6) // Ambil 6 data untuk ditampilkan
                        ->get();

        // Data guru (tetap array)
        $guru = [
            [
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jabatan' => 'Kepala Sekolah',
                'deskripsi' => 'S1 Pendidikan Anak Usia Dini, 15 tahun pengalaman',
                'foto' => 'images/kepala-sekolah.jpg'
            ],
            // ... data guru lainnya
        ];

        return view('home', compact('beritas', 'galeris', 'guru'));
    }
}