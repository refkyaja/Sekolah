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
        
        // Cek status kelulusan dari SPMB
        $spmb = \App\Models\Spmb::where('nik_anak', $siswa->nik)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $isLulus = false;
        $showPengumumanLulus = false;
        
        if ($spmb) {
            $isLulus = $spmb->status_pendaftaran === 'Lulus';
            
            // Cek apakah waktu pengumuman sudah selesai
            $setting = \App\Models\SpmbSetting::where('tahun_ajaran', $spmb->tahunAjaran->tahun_ajaran ?? date('Y'))->first();
            if ($setting && $setting->status_pengumuman === 'published') {
                $now = now();
                $pengumumanSelesai = $setting->pengumuman_selesai;
                
                // Tampilkan notifikasi lulus jika waktu pengumuman sudah selesai
                if ($pengumumanSelesai && $now->gte($pengumumanSelesai)) {
                    $showPengumumanLulus = true;
                }
            }
        }
        
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
        
        return view('siswa.dashboard', compact('siswa', 'pengumuman', 'materiTerbaru', 'todaySchedule', 'spmb', 'isLulus', 'showPengumumanLulus'));
    }
}
