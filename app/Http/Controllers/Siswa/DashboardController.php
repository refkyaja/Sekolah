<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $siswa = auth('siswa')->user();
        $pengumuman = \App\Models\Berita::published()->latestPublished(3)->get();
        
        // Fetch latest materials for this student
        $kelompokFull = "Kelompok " . ($siswa->kelompok ?? 'A');
        
        $materiTerbaru = \App\Models\MateriKbm::where(function($q) use ($siswa, $kelompokFull) {
            $q->where('kelas', $kelompokFull)
              ->orWhere('kelas', 'Semua Kelas');
        })
        ->where(function($q) use ($siswa) {
            if ($siswa->kelas) {
                $q->where(function($sub) use ($siswa) {
                    $sub->where('kelompok', $siswa->kelas)
                        ->orWhereNull('kelompok')
                        ->orWhere('kelompok', 'like', $siswa->kelompok . '%');
                });
            }
        })
        ->latest('tanggal_publish')
        ->take(3)
        ->get();

        // Fetch today's schedule
        $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::first();
        $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');
        // Handle mapping if isoFormat returns something different from our hariList (Indonesian)
        // Carbon::now()->isoFormat('dddd') usually returns names like 'Senin', 'Selasa', etc if locale is set to 'id'
        
        $todaySchedule = [];
        if ($ta) {
            $todaySchedule = \App\Models\JadwalPelajaran::where('kelompok', $siswa->kelompok ?? 'A')
                ->where('tahun_ajaran_id', $ta->id)
                ->where('semester', $ta->semester)
                ->where('hari', $hariIni)
                ->orderBy('jam_mulai')
                ->get();
        }
        
        return view('siswa.dashboard', compact('siswa', 'pengumuman', 'materiTerbaru', 'todaySchedule'));
    }
}
