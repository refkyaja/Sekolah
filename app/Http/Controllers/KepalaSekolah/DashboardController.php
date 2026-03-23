<?php

namespace App\Http\Controllers\KepalaSekolah;

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
use Illuminate\Support\Facades\DB;
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
        $siswa_lulus = Siswa::where('status_siswa', 'lulus')->count();
        
        // Data Guru
        $total_guru = Guru::count();
        
        // Data PPDB (SPMB)
        $total_ppdb = Spmb::when($tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaranId))->count();
        $pendaftaran_baru = Spmb::where('status_pendaftaran', 'Menunggu Verifikasi')
            ->when($tahunAjaranId, function($query) use ($tahunAjaranId) {
                return $query->where('tahun_ajaran_id', $tahunAjaranId);
            })
            ->count();
        
        // Recent Pendaftaran SPMB (5 terbaru)
        $recent_pendaftaran = Spmb::with(['tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistik Absensi Hari Ini
        $absensi_hari_ini = Absensi::whereDate('tanggal', today())->count();
        $persen_absen = $total_siswa > 0
            ? round(min(100, ($absensi_hari_ini / $total_siswa) * 100), 1)
            : 0;
        
        // Compile statistics untuk cards
        $stats = [
            'siswa_aktif' => $siswa_aktif,
            'siswa_lulus' => $siswa_lulus,
            'total_siswa' => $total_siswa,
            'total_guru' => $total_guru,
            'pendaftaran_baru' => $pendaftaran_baru,
            'ppdb_total' => $total_ppdb,
            'absensi_hari_ini' => $absensi_hari_ini,
            'persen_absen' => $persen_absen,
        ];

        return view('kepala-sekolah.dashboard', compact(
            'stats',
            'recent_pendaftaran'
        ));
    }
}
