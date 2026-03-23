<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\User;
use App\Models\Spmb;
use App\Models\TahunAjaran;
use App\Models\BukuTamu;
use App\Models\Absensi;
use App\Models\MateriKbm;
use App\Models\KalenderAkademik;
use App\Models\JadwalPelajaran;
use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tahunAjaranAktif = TahunAjaran::where('is_aktif', true)->first();
        $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        
        // Data Siswa
        $total_siswa = Siswa::aktif()->count();
        $siswa_aktif = Siswa::aktif()->count();
        
        // Statistik Absensi Hari Ini
        $absensi_hari_ini = Absensi::whereDate('tanggal', today())->count();
        $persen_absen = $total_siswa > 0
            ? round(min(100, ($absensi_hari_ini / $total_siswa) * 100), 1)
            : 0;
        
        // Data Kalender Akademik
        $total_kalender = KalenderAkademik::count();
        
        // Data Galeri
        $total_galeri = Galeri::count();
        
        // Data Kegiatan
        $total_kegiatan = Kegiatan::count();
        $kegiatan_terbaru = Kegiatan::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Compile statistics untuk cards
        $stats = [
            'siswa_aktif' => $siswa_aktif,
            'total_siswa' => $total_siswa,
            'absensi_hari_ini' => $absensi_hari_ini,
            'persen_absen' => $persen_absen,
            'total_kalender' => $total_kalender,
            'total_galeri' => $total_galeri,
            'total_kegiatan' => $total_kegiatan,
        ];

        return view('guru.dashboard', compact(
            'stats',
            'kegiatan_terbaru'
        ));
    }
}
