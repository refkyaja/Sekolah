<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkademikController extends Controller
{
    public function kegiatan()
    {
        return view('Home.akademik.kegiatan', [
            'title' => 'Kegiatan Sekolah',
            'kegiatan' => [
                'Upacara Bendera',
                'Field Trip',
                'Pentas Seni',
                'Hari Besar Nasional'
            ]
        ]);
    }

    public function prestasi()
    {
        return view('Home.akademik.prestasi', [
            'title' => 'Prestasi Siswa',
            'prestasi' => [
                'Juara 1 Lomba Mewarnai Tingkat Kota',
                'Juara 2 Lomba Menyanyi TK Se-Kecamatan',
                'Juara 3 Lomba Cerita Bergambar'
            ]
        ]);
    }

    public function ekstrakurikuler()
    {
        return view('Home.akademik.ekstrakurikuler', [
            'title' => 'Ekstrakurikuler',
            'ekskul' => [
                'Tari Tradisional',
                'Menggambar & Mewarnai',
                'Bermain Musik',
                'Bercerita (Story Telling)'
            ]
        ]);
    }

    public function bahanAjar()
    {
        return view('Home.akademik.bahan-ajar', [
            'title' => 'Bahan Ajar',
            'materi' => [
                'Pengenalan Huruf & Angka',
                'Pengembangan Motorik Halus & Kasar',
                'Pembentukan Karakter',
                'Pengenalan Alam & Lingkungan'
            ]
        ]);
    }
}