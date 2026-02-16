<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function sejarah()
    {
        return view('Home.profil.sejarah', [
            'title' => 'Sejarah TK Ceria Bangsa',
            'content' => 'TK Ceria Bangsa didirikan pada tahun 2010 dengan visi memberikan pendidikan usia dini yang berkualitas...'
        ]);
    }

    public function sambutan()
    {
        return view('Home.profil.sambutan', [
            'title' => 'Sambutan Kepala Sekolah',
            'kepala_sekolah' => 'Ibu Siti Nurhaliza, S.Pd',
            'sambutan' => 'Selamat datang di TK Ceria Bangsa...'
        ]);
    }

    public function visimisi()
    {
        return view('Home.profil.visimisi', [
            'title' => 'Visi & Misi',
            'visi' => 'Menjadi lembaga pendidikan anak usia dini terdepan...',
            'misi' => [
                'Menyelenggarakan pendidikan berkualitas',
                'Mengembangkan potensi anak',
                'Membentuk karakter berakhlak mulia',
                'Melibatkan orang tua dalam pendidikan'
            ]
        ]);
    }

    public function program()
    {
        return view('Home.profil.program', [
            'title' => 'Program Sekolah',
            'programs' => [
                'Kelompok Bermain (Play Group)',
                'TK A (4-5 tahun)',
                'TK B (5-6 tahun)',
                'Program Full Day',
                'Ekstrakurikuler: Menari, Menggambar, Musik'
            ]
        ]);
    }

    public function lokasi()
    {
        return view('Home.profil.lokasi', [
            'title' => 'Lokasi Sekolah',
            'alamat' => 'Jl. Pendidikan No. 123, Bandung',
            'maps_url' => 'https://goo.gl/maps/...'
        ]);
    }
}